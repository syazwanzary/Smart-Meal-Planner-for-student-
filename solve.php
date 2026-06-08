<?php
include 'config.php';

// Get data from input form
$problem_title = mysqli_real_escape_string($conn, $_POST['problem_title']);
$objective_type = mysqli_real_escape_string($conn, $_POST['objective_type']);
$budget = floatval($_POST['budget']);
$calorie_requirement = intval($_POST['calories']);
$protein_requirement = floatval($_POST['protein']);
$selected_foods = $_POST['foods']; // Array of food IDs

// If no foods selected, go back
if(empty($selected_foods)) {
    header("Location: input.php?error=Please select at least one food");
    exit();
}

// Create list of food IDs for SQL query
$food_ids = implode(',', $selected_foods);

// Fetch selected foods from database
$query = "SELECT * FROM foods WHERE id IN ($food_ids)";
$result = mysqli_query($conn, $query);
$foods = [];
while($row = mysqli_fetch_assoc($result)) {
    $foods[] = $row;
}

$num_foods = count($foods);

// =====================================================
// BRUTE FORCE OPTIMIZATION ALGORITHM
// Tries all combinations to find the best solution
// =====================================================

$best_solution = null;
$best_objective_value = ($objective_type == 'minimize_cost') ? PHP_FLOAT_MAX : 0;

// Max servings per food (limit to 10 for performance)
$max_servings = 10;

// Calculate total combinations to try
$total_combinations = pow($max_servings + 1, $num_foods);
$progress_step = max(1, floor($total_combinations / 100));

// Initialize counters for progress
$combinations_tried = 0;

// Nested loops for brute force (works for up to 5-6 foods)
// For more foods, this would need a better algorithm

// Create an array to hold current servings
$current_servings = array_fill(0, $num_foods, 0);

// Recursive function to try all combinations
function tryCombinations($food_index, $current_servings, &$best_solution, &$best_objective_value, $foods, $budget, $calorie_requirement, $protein_requirement, $objective_type, $max_servings, $num_foods) {
    
    if($food_index == $num_foods) {
        // Calculate totals for this combination
        $total_cost = 0;
        $total_calories = 0;
        $total_protein = 0;
        
        for($i = 0; $i < $num_foods; $i++) {
            $total_cost += $current_servings[$i] * $foods[$i]['cost_per_serving'];
            $total_calories += $current_servings[$i] * $foods[$i]['calories_per_serving'];
            $total_protein += $current_servings[$i] * $foods[$i]['protein_per_serving'];
        }
        
        // Check if constraints are satisfied
        $budget_ok = ($total_cost <= $budget);
        $calories_ok = ($total_calories >= $calorie_requirement);
        $protein_ok = ($total_protein >= $protein_requirement);
        
        if($budget_ok && $calories_ok && $protein_ok) {
            // This combination is feasible
            
            $is_better = false;
            
            if($objective_type == 'minimize_cost') {
                // Minimize cost
                if($total_cost < $best_objective_value) {
                    $best_objective_value = $total_cost;
                    $is_better = true;
                }
            } 
            elseif($objective_type == 'maximize_protein') {
                // Maximize protein
                if($total_protein > $best_objective_value) {
                    $best_objective_value = $total_protein;
                    $is_better = true;
                }
            }
            else {
                // Balanced: minimize cost while meeting protein (priority to cost)
                $score = $total_cost - ($total_protein / 100); // Small protein bonus
                if($score < $best_objective_value) {
                    $best_objective_value = $score;
                    $is_better = true;
                }
            }
            
            if($is_better) {
                $best_solution = [
                    'servings' => $current_servings,
                    'total_cost' => $total_cost,
                    'total_calories' => $total_calories,
                    'total_protein' => $total_protein
                ];
            }
        }
        
        return;
    }
    
    // Try all possible servings for this food
    for($s = 0; $s <= $max_servings; $s++) {
        $current_servings[$food_index] = $s;
        tryCombinations($food_index + 1, $current_servings, $best_solution, $best_objective_value, $foods, $budget, $calorie_requirement, $protein_requirement, $objective_type, $max_servings, $num_foods);
    }
}

// Run the optimization
tryCombinations(0, $current_servings, $best_solution, $best_objective_value, $foods, $budget, $calorie_requirement, $protein_requirement, $objective_type, $max_servings, $num_foods);

// =====================================================
// SAVE TO DATABASE
// =====================================================

// Insert problem into database
$insert_problem = "INSERT INTO problems (problem_title, objective_type, budget_limit, calorie_requirement, protein_requirement) 
                   VALUES ('$problem_title', '$objective_type', $budget, $calorie_requirement, $protein_requirement)";
mysqli_query($conn, $insert_problem);
$problem_id = mysqli_insert_id($conn);

// Link foods to this problem
foreach($selected_foods as $food_id) {
    $insert_link = "INSERT INTO problem_foods (problem_id, food_id) VALUES ($problem_id, $food_id)";
    mysqli_query($conn, $insert_link);
}

// If a solution was found, save it
$solution_found = ($best_solution != null);

if($solution_found) {
    // Save solution summary
    $insert_summary = "INSERT INTO solution_summary (problem_id, total_cost, total_calories, total_protein, is_feasible) 
                       VALUES ($problem_id, {$best_solution['total_cost']}, {$best_solution['total_calories']}, {$best_solution['total_protein']}, 1)";
    mysqli_query($conn, $insert_summary);
    
    // Save individual food solutions
    for($i = 0; $i < $num_foods; $i++) {
        if($best_solution['servings'][$i] > 0) {
            $food_id = $foods[$i]['id'];
            $servings = $best_solution['servings'][$i];
            $cost_contrib = $servings * $foods[$i]['cost_per_serving'];
            $calories_contrib = $servings * $foods[$i]['calories_per_serving'];
            $protein_contrib = $servings * $foods[$i]['protein_per_serving'];
            
            $insert_solution = "INSERT INTO solutions (problem_id, food_id, optimal_servings, cost_contribution, calories_contribution, protein_contribution) 
                               VALUES ($problem_id, $food_id, $servings, $cost_contrib, $calories_contrib, $protein_contrib)";
            mysqli_query($conn, $insert_solution);
        }
    }
} else {
    // No solution found
    $insert_summary = "INSERT INTO solution_summary (problem_id, total_cost, total_calories, total_protein, is_feasible) 
                       VALUES ($problem_id, 0, 0, 0, 0)";
    mysqli_query($conn, $insert_summary);
}

// Store data in session to show on result page
session_start();
$_SESSION['solution_found'] = $solution_found;
$_SESSION['problem_id'] = $problem_id;
$_SESSION['foods'] = $foods;
$_SESSION['best_solution'] = $best_solution;
$_SESSION['budget'] = $budget;
$_SESSION['calorie_requirement'] = $calorie_requirement;
$_SESSION['protein_requirement'] = $protein_requirement;
$_SESSION['objective_type'] = $objective_type;

// Redirect to result page
header("Location: result.php");
exit();
?>