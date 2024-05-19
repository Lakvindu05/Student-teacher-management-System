<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_username'])) {
    header('Location: student-login.php');
    exit();
}

// Include the database connection
include 'db-connect.php';

// Get student details from the database
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
        .container {
            width: 80%;
            margin: auto;
        }
        .menu a {
            display: block;
            margin: 10px 0;
            text-decoration: none;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($student['name']); ?>!</h1>
        <div class="menu">
            <a href="student-profile.php">Profile</a>
            <a href="view-student-schedule.php">View Schedule</a>
            <a href="view-results.php">View Results</a>
            <a href="view-announcements.php">View Announcements</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
