<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: admin-login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
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
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="admin-profile.php">Profile</a></li>
            <li><a href="add-teachers.php">Add Teachers</a></li>
            <li><a href="add-teacher-schedules.php">Add Teacher Schedules</a></li>
            <li><a href="add-student.php">Add Student</a></li>
            <li><a href="add-student-schedule.php">Add Student Schedules</a></li>
            <li><a href="create-announcements.php">Create Announcements</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
