<?php
session_start();
include 'db-connect.php';

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_username'])) {
    header('Location: teacher-login.php');
    exit();
}

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch teacher's profile information
$teacher_username = $_SESSION['teacher_username'];
$sql = "SELECT fullname, username, email, phone_number, address, qualifications FROM Teachers WHERE username = '$teacher_username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $teacher = $result->fetch_assoc();
} else {
    echo "Error fetching profile details.";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Profile</title>
</head>
<body>
    <h2>Teacher Profile</h2>
    <div style="width: 80%; margin: auto;">
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($teacher['fullname']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($teacher['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($teacher['email']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($teacher['phone_number']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($teacher['address']); ?></p>
        <p><strong>Qualifications:</strong> <?php echo htmlspecialchars($teacher['qualifications']); ?></p>
    </div>
    <br>
    <a href="teacher-panel.php">Back to Teacher Panel</a>
</body>
</html>
