<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Meal Planner - History</title>
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
            padding: 30px 20px;
        }
        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .history-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .btn-view {
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
        }
        .btn-view:hover {
            background: #764ba2;
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
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        .status-feasible {
            color: #28a745;
            font-weight: bold;
        }
        .status-not {
            color: #dc3545;
            font-weight: bold;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Your Saved Meal Plans</h1>
            <p>View all your optimization history</p>
        </div>

        <div class="history-card">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="🔍 Search by problem title..." onkeyup="searchTable()">
            </div>

            <table id="historyTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Problem Title</th>
                        <th>Date</th>
                        <th>Budget (RM)</th>
                        <th>Calories</th>
                        <th>Protein (g)</th>
                        <th>Total Cost (RM)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM problems_with_solutions ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);
                    $count = 1;
                    
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $is_feasible = $row['is_feasible'];
                            $total_cost = $row['total_cost'] ? number_format($row['total_cost'], 2) : '-';
                            $status_class = $is_feasible ? 'status-feasible' : 'status-not';
                            $status_text = $is_feasible ? '✅ Optimal' : '❌ No Solution';
                            
                            echo "<tr>";
                            echo "<td>" . $count++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['problem_title']) . "</td>";
                            echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
                            echo "<td>RM " . number_format($row['budget_limit'], 2) . "</td>";
                            echo "<td>" . number_format($row['calorie_requirement']) . "</td>";
                            echo "<td>" . number_format($row['protein_requirement']) . "</td>";
                            echo "<td>RM " . $total_cost . "</td>";
                            echo "<td class='$status_class'>$status_text</td>";
                            echo "<td><a href='view_solution.php?id=" . $row['id'] . "' class='btn-view'>View Details →</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='no-data'>No meal plans saved yet. <a href='input.php'>Create your first meal plan!</a></td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <a href="index.php" class="btn-back">← Back to Home</a>
        </div>
    </div>

    <script>
        function searchTable() {
            let input = document.getElementById("searchInput");
            let filter = input.value.toUpperCase();
            let table = document.getElementById("historyTable");
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    let textValue = td.textContent || td.innerText;
                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>