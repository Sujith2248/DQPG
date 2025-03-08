<?php
// Database configuration
$host = "localhost";    // Database host
$dbname = "qpg_appdb"; // Database name
$username = "root";    // Database username
$password = "";    // Database password

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
