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
</head>
<body>
    <h1>Admin Panel</h1>
    <nav>
        <ul>
            <li><a href="admin-profile.php">Profile</a></li>
            <li><a href="add-teachers.php">Add Teachers</a></li>
            <li><a href="add-schedules.php">Add Schedules</a></li>
            <li><a href="create-announcements.php">Create Announcements</a></li>
        </ul>
    </nav>
</body>
</html>
