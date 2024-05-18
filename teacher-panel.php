<?php
session_start();

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_username'])) {
    header('Location: teacher-login.php');
    exit();
}

echo "Welcome, " . $_SESSION['teacher_username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Panel</title>
</head>
<body>
    <h2>Teacher Panel</h2>
    <nav>
        <ul>
            <li><a href="teacher-profile.php">Profile</a></li>
            <li><a href="update-student.php">Update Student</a></li>
            <li><a href="update-student-schedule.php">Update Student Schedules</a></li>
            <li><a href="add-results.php">Add Results</a></li>
        </ul>
    </nav>
</body>
</html>
