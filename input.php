<?php include 'config.php'; ?>

<?php
// Fetch all foods from database to display as checkboxes
$foods_query = "SELECT * FROM foods ORDER BY name";
$foods_result = mysqli_query($conn, $foods_query);
$all_foods = mysqli_fetch_all($foods_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Meal Planner - Create Meal Plan</title>
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
            max-width: 800px;
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
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="number"], select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .food-checkbox-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        .food-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            background: #f5f5f5;
            border-radius: 8px;
        }
        .food-checkbox input {
            width: 20px;
            height: 20px;
        }
        .food-checkbox label {
            margin: 0;
            font-weight: normal;
            cursor: pointer;
        }
        .food-info {
            font-size: 12px;
            color: #666;
            margin-left: 30px;
        }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn-submit:hover {
            opacity: 0.9;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            color: #667eea;
            text-decoration: none;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #667eea;
            color: #333;
        }
        .note {
            background: #fff3cd;
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 14px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Create Your Meal Plan</h1>
            <p>Enter your budget and nutrition goals</p>
        </div>

        <div class="form-card">
            <form action="solve.php" method="POST">
                <div class="form-group">
                    <label>📋 Problem Title</label>
                    <input type="text" name="problem_title" placeholder="e.g., My Weekly Meal Plan" required>
                </div>

                <div class="form-group">
                    <label>🎯 Objective Type</label>
                    <select name="objective_type" required>
                        <option value="minimize_cost">Minimize Cost (Save Money)</option>
                        <option value="maximize_protein">Maximize Protein (Build Muscle)</option>
                        <option value="balance">Balanced (Cost + Protein)</option>
                    </select>
                </div>

                <div class="section-title">💰 Budget & Nutrition Goals</div>

                <div class="form-group">
                    <label>💰 Weekly Budget (RM)</label>
                    <input type="number" name="budget" step="0.01" value="50" required>
                </div>

                <div class="form-group">
                    <label>🔥 Minimum Calories per Day</label>
                    <input type="number" name="calories" value="2000" required>
                    <small>Recommended: 1800-2200 for students</small>
                </div>

                <div class="form-group">
                    <label>💪 Minimum Protein per Day (grams)</label>
                    <input type="number" name="protein" step="1" value="50" required>
                    <small>Recommended: 50-70g for active students</small>
                </div>

                <div class="section-title">🥗 Select Available Foods</div>

                <div class="food-checkbox-group">
                    <?php foreach($all_foods as $food): ?>
                    <div class="food-checkbox">
                        <input type="checkbox" name="foods[]" value="<?php echo $food['id']; ?>" checked>
                        <label>
                            <?php echo $food['name']; ?>
                            <br>
                            <small class="food-info">
                                RM<?php echo $food['cost_per_serving']; ?> | 
                                <?php echo $food['calories_per_serving']; ?> cal | 
                                <?php echo $food['protein_per_serving']; ?>g protein
                            </small>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="note">
                    💡 <strong>How it works:</strong> The system will calculate the optimal number of servings for each food to meet your nutrition needs while staying within budget.
                </div>

                <button type="submit" class="btn-submit">🚀 Find Optimal Meal Plan →</button>
            </form>

            <a href="index.php" class="btn-back">← Back to Home</a>
        </div>
    </div>
</body>
</html>