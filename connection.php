<?php

// $host = "localhost";
//  $id = "root";
//  $pass = "";
//  $database = "dbexam";
//  $user = "SiteAdmin";
//  $errordb="Unable to select database";
//  $error = "Unable to connect to the database check again..!!";
// $conn = mysqli_connect($host,$id,$pass,$database) or die ($error);
// mysql_select_db($database,$conn)or die ($errordb);

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

 ?>