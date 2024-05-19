<?php
session_start();

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_username'])) {
    header('Location: teacher-login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Panel</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
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
        .sidebar ul {
            padding: 0;
            list-style: none;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a,
        .sidebar h1 {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover {
            background-color: #333;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Teacher Panel</h2>
        <ul>
            <li><a href="teacher-profile.php">Profile</a></li>
            <li><a href="update-student.php">Update Student</a></li>
            <li><a href="update-student-schedule.php">Update Student Schedules</a></li>
            <li><a href="add-results.php">Add Results</a></li>
            <li><a href="view-announcements.php">View Announcements</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
