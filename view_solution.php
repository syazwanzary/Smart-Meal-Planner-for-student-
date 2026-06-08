<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Meal Planner - Solution Details</title>
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
        .detail-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
        .meal-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .food-name {
            font-weight: bold;
            flex: 2;
        }
        .servings {
            flex: 1;
            text-align: center;
            color: #667eea;
        }
        .cost {
            flex: 1;
            text-align: right;
            color: #28a745;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 25px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }
        h2 {
            margin: 20px 0 10px 0;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Meal Plan Details</h1>
            <p>View your saved optimization results</p>
        </div>

        <div class="detail-card">
            <?php
            $problem_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            
            // Get problem details
            $problem_query = "SELECT * FROM problems WHERE id = $problem_id";
            $problem_result = mysqli_query($conn, $problem_query);
            
            if(mysqli_num_rows($problem_result) == 0) {
                echo "<div class='error'>❌ Problem not found!</div>";
                echo "<a href='history.php' class='btn-back'>← Back to History</a>";
                exit();
            }
            
            $problem = mysqli_fetch_assoc($problem_result);
            
            // Get solution summary
            $summary_query = "SELECT * FROM solution_summary WHERE problem_id = $problem_id";
            $summary_result = mysqli_query($conn, $summary_query);
            $has_solution = mysqli_num_rows($summary_result) > 0;
            
            if($has_solution) {
                $summary = mysqli_fetch_assoc($summary_result);
                $is_feasible = $summary['is_feasible'];
            }
            
            // Get individual food solutions
            $solutions_query = "SELECT s.*, f.name, f.cost_per_serving, f.calories_per_serving, f.protein_per_serving 
                               FROM solutions s 
                               JOIN foods f ON s.food_id = f.id 
                               WHERE s.problem_id = $problem_id";
            $solutions_result = mysqli_query($conn, $solutions_query);
            ?>
            
            <?php if($has_solution && $is_feasible): ?>
                <div class="summary-box">
                    <div class="summary-item">
                        <h3>💰 Total Cost</h3>
                        <p>RM <?php echo number_format($summary['total_cost'], 2); ?></p>
                        <small>Budget: RM <?php echo number_format($problem['budget_limit'], 2); ?></small>
                    </div>
                    <div class="summary-item">
                        <h3>🔥 Total Calories</h3>
                        <p><?php echo number_format($summary['total_calories']); ?> cal</p>
                        <small>Target: <?php echo number_format($problem['calorie_requirement']); ?> cal</small>
                    </div>
                    <div class="summary-item">
                        <h3>💪 Total Protein</h3>
                        <p><?php echo number_format($summary['total_protein'], 1); ?> g</p>
                        <small>Target: <?php echo number_format($problem['protein_requirement']); ?> g</small>
                    </div>
                </div>

                <h2>🥗 Recommended Meal Plan</h2>
                <?php if(mysqli_num_rows($solutions_result) > 0): ?>
                    <?php while($solution = mysqli_fetch_assoc($solutions_result)): ?>
                        <div class="meal-item">
                            <div class="food-name">🍽️ <?php echo htmlspecialchars($solution['name']); ?></div>
                            <div class="servings"><?php echo $solution['optimal_servings']; ?> serving(s)</div>
                            <div class="cost">RM <?php echo number_format($solution['cost_contribution'], 2); ?></div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #999;">No food details available.</p>
                <?php endif; ?>
                
            <?php elseif($has_solution && !$is_feasible): ?>
                <div class="error">
                    ❌ <strong>No Solution Found</strong>
                    <p style="margin-top: 10px;">This meal plan could not be optimized with the given constraints.</p>
                </div>
            <?php else: ?>
                <div class="error">
                    ❌ No solution data available for this problem.
                </div>
            <?php endif; ?>
            
            <div style="margin-top: 20px;">
                <strong>📅 Created:</strong> <?php echo date('d/m/Y H:i:s', strtotime($problem['created_at'])); ?>
            </div>
            
            <a href="history.php" class="btn-back">← Back to History</a>
        </div>
    </div>
</body>
</html>