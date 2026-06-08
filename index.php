<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Meal Planner - Home</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            color: white;
            padding: 40px 20px;
        }
        .header h1 {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 18px;
            opacity: 0.9;
        }
        .card-container {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 40px;
        }
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            width: 300px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 24px;
        }
        .card p {
            color: #666;
            margin-bottom: 25px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: opacity 0.3s;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .footer {
            text-align: center;
            color: white;
            margin-top: 60px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍽️ Smart Meal Planner</h1>
            <p>Optimize your meals - Stay healthy on a student budget!</p>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>📝 New Meal Plan</h3>
                <p>Create a new optimization problem. Set your budget, calorie needs, and protein requirements.</p>
                <a href="input.php" class="btn">Get Started →</a>
            </div>

            <div class="card">
                <h3>📊 View History</h3>
                <p>See all your saved meal plans and previous optimization results.</p>
                <a href="history.php" class="btn">View History →</a>
            </div>

            <div class="card">
                <h3>📖 About This System</h3>
                <p>Learn how Linear Programming helps you eat better for less money.</p>
                <a href="about.php" class="btn">Learn More →</a>
            </div>
        </div>

        <div class="footer">
            <p>Smart Meal Planner - Linear Programming Optimization System</p>
        </div>
    </div>
</body>
</html>