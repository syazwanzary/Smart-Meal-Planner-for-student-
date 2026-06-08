<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "meal_planner_db";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8");

// For easy queries
function runQuery($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    if(!$result) {
        die("Query Error: " . mysqli_error($conn));
    }
    return $result;
}
?>