<!-- db-connect.php -->
<?php

// Database configuration
$servername = "localhost";
$dbname = "marristelladb";
$db_username = "root"; // change this to your database username
$db_password = ""; // change this to your database password

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
