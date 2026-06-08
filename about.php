<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Meal Planner - About</title>
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
        .about-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            color: #667eea;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #667eea;
        }
        .section p {
            line-height: 1.6;
            color: #333;
        }
        .formula {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 10px;
            font-family: monospace;
            margin: 10px 0;
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
        .group-members {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📖 About Smart Meal Planner</h1>
            <p>Learn how Linear Programming helps you eat better</p>
        </div>

        <div class="about-card">
            <div class="section">
                <h2>🎯 Problem Statement</h2>
                <p>University students often struggle to eat healthy meals because they have limited budgets. Many students end up eating cheap, unhealthy food that affects their health and academic performance. This system helps students find the optimal combination of foods that meet their nutrition needs while staying within budget.</p>
            </div>

            <div class="section">
                <h2>📐 Linear Programming Formulation</h2>
                <p>We formulate this as a Linear Programming problem:</p>
                <div class="formula">
                    <strong>Decision Variables:</strong><br>
                    x₁ = servings of rice<br>
                    x₂ = servings of chicken<br>
                    x₃ = servings of eggs<br>
                    x₄ = servings of vegetables<br>
                    x₅ = servings of fruits<br><br>
                    
                    <strong>Objective Function (Minimize Cost):</strong><br>
                    Minimize: 2x₁ + 5x₂ + 1.5x₃ + 2x₄ + 1.5x₅<br><br>
                    
                    <strong>Constraints:</strong><br>
                    2x₁ + 5x₂ + 1.5x₃ + 2x₄ + 1.5x₅ ≤ 50 (Budget in RM)<br>
                    200x₁ + 250x₂ + 140x₃ + 50x₄ + 80x₅ ≥ 2000 (Calories)<br>
                    4x₁ + 25x₂ + 12x₃ + 2x₄ + 0.5x₅ ≥ 50 (Protein in grams)<br>
                    x₁, x₂, x₃, x₄, x₅ ≥ 0 (Non-negativity)
                </div>
            </div>

            <div class="section">
                <h2>⚙️ How The System Works</h2>
                <p>1. User enters their budget, calorie needs, and protein requirements<br>
                2. User selects available foods from the database<br>
                3. The system uses a brute-force optimization algorithm to try all possible combinations<br>
                4. It finds the combination that meets all constraints while minimizing cost or maximizing nutrition<br>
                5. Results are saved to MySQL database for future reference</p>
            </div>

            <div class="section">
                <h2>💡 Why This Is Useful</h2>
                <p>✅ Saves money by finding the cheapest meal plan<br>
                ✅ Ensures students meet daily nutrition requirements<br>
                ✅ Helps with meal planning and grocery shopping<br>
                ✅ Educational tool to learn about Linear Programming</p>
            </div>

            <div class="group-members">
                <h2>👥 Group Members</h2>
                <p><strong>Group Name:</strong> Smart Meal Planner Team</p>
                <p><strong>Members:</strong><br>
                1. Syazwan Zary - [Your Matrix Number]<br>
                2. [Member 2 Name] - [Matrix Number]<br>
                3. [Member 3 Name] - [Matrix Number]<br>
                4. [Member 4 Name] - [Matrix Number]
                </p>
                <p><strong>Course:</strong> Linear Programming Optimization<br>
                <strong>Project Date:</strong> June 2026</p>
            </div>

            <a href="index.php" class="btn-back">← Back to Home</a>
        </div>
    </div>
</body>
</html>