<?php
session_start();

// Check if we have solution data
if(!isset($_SESSION['problem_id'])) {
    header("Location: input.php");
    exit();
}

$solution_found = $_SESSION['solution_found'];
$problem_id = $_SESSION['problem_id'];
$foods = $_SESSION['foods'];
$best_solution = $_SESSION['best_solution'];
$budget = $_SESSION['budget'];
$calorie_requirement = $_SESSION['calorie_requirement'];
$protein_requirement = $_SESSION['protein_requirement'];
$objective_type = $_SESSION['objective_type'];

// Clear session data after retrieving
session_destroy();
session_start(); // Start new session for later use
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Meal Planner - Results</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            color: white;
            padding: 30px 20px;
        }
        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .result-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .summary-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            text-align: center;
        }
        .summary-item {
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 10px;
        }
        .summary-item h3 {
            font-size: 14px;
            margin-bottom: 5px;
            opacity: 0.9;
        }
        .summary-item p {
            font-size: 24px;
            font-weight: bold;
        }
        .meal-plan {
            margin-top: 20px;
        }
        .meal-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            border-bottom: 1px solid #eee;
            align-items: center;
        }
        .meal-item:hover {
            background: #f5f5f5;
        }
        .food-name {
            font-weight: bold;
            font-size: 18px;
            flex: 2;
        }
        .servings {
            flex: 1;
            text-align: center;
            color: #667eea;
            font-weight: bold;
        }
        .cost {
            flex: 1;
            text-align: right;
            color: #28a745;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 10px 5px;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        .constraints {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Your Optimal Meal Plan</h1>
            <p>Here's what Linear Programming recommends</p>
        </div>

        <div class="result-card">
            <?php if($solution_found): ?>
                <div class="success">
                    ✅ <strong>Solution Found!</strong> We found an optimal meal plan that meets your requirements!
                </div>

                <div class="summary-box">
                    <div class="summary-item">
                        <h3>💰 Total Cost</h3>
                        <p>RM <?php echo number_format($best_solution['total_cost'], 2); ?></p>
                        <small>Budget: RM <?php echo number_format($budget, 2); ?></small>
                    </div>
                    <div class="summary-item">
                        <h3>🔥 Total Calories</h3>
                        <p><?php echo number_format($best_solution['total_calories']); ?> cal</p>
                        <small>Target: <?php echo number_format($calorie_requirement); ?> cal</small>
                    </div>
                    <div class="summary-item">
                        <h3>💪 Total Protein</h3>
                        <p><?php echo number_format($best_solution['total_protein'], 1); ?> g</p>
                        <small>Target: <?php echo number_format($protein_requirement); ?> g</small>
                    </div>
                </div>

                <div class="constraints">
                    <strong>🎯 Optimization Goal:</strong> 
                    <?php 
                    if($objective_type == 'minimize_cost') echo "Minimize Cost (Save as much money as possible)";
                    elseif($objective_type == 'maximize_protein') echo "Maximize Protein (Build more muscle)";
                    else echo "Balanced (Minimize cost while meeting protein goals)";
                    ?>
                </div>

                <h2>🥗 Your Daily Meal Plan</h2>
                <div class="meal-plan">
                    <?php 
                    $has_food = false;
                    for($i = 0; $i < count($foods); $i++): 
                        if($best_solution['servings'][$i] > 0):
                            $has_food = true;
                    ?>
                        <div class="meal-item">
                            <div class="food-name">🍽️ <?php echo $foods[$i]['name']; ?></div>
                            <div class="servings"><?php echo $best_solution['servings'][$i]; ?> serving(s)</div>
                            <div class="cost">RM <?php echo number_format($best_solution['servings'][$i] * $foods[$i]['cost_per_serving'], 2); ?></div>
                        </div>
                    <?php 
                        endif;
                    endfor; 
                    
                    if(!$has_food):
                    ?>
                        <div style="text-align: center; padding: 20px; color: #999;">
                            No specific foods recommended. Try selecting different foods or increasing your budget.
                        </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="error">
                    ❌ <strong>No Solution Found!</strong> 
                    <p style="margin-top: 10px;">We couldn't find a meal plan that meets all your requirements with the selected foods.</p>
                </div>
                
                <div class="constraints">
                    <strong>💡 Suggestions:</strong>
                    <ul style="margin-top: 10px; margin-left: 20px;">
                        <li>Increase your budget (currently RM <?php echo number_format($budget, 2); ?>)</li>
                        <li>Lower your calorie requirement (currently <?php echo $calorie_requirement; ?> cal)</li>
                        <li>Lower your protein requirement (currently <?php echo $protein_requirement; ?> g)</li>
                        <li>Select more affordable food options</li>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="buttons">
                <a href="input.php" class="btn">📝 Create Another Plan</a>
                <a href="history.php" class="btn btn-secondary">📊 View History</a>
                <a href="index.php" class="btn btn-secondary">🏠 Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>