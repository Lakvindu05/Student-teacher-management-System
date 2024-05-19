<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_username'])) {
    header('Location: student-login.php');
    exit();
}

// Include the database connection
include 'db-connect.php';

// Get the student's details from the database
$username = $_SESSION['student_username'];
$sql = "SELECT * FROM Students WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found!";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="student-panel.php">Profile</a>
        <a href="view-student-schedule.php">View Schedule</a>
        <a href="view-results.php">View Results</a>
        <a href="view-announcements.php">View Announcements</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
