<?php
session_start();
include 'db-connect.php';

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_username'])) {
    header('Location: teacher-login.php');
    exit();
}

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .profile-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .profile-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .profile-container p {
            margin: 10px 0;
            color: #555;
        }
        .profile-container p strong {
            color: #333;
        }
    </style>
</head>
<body>
    <?php include 'teacher-panel.php'?>
    <div class="content">
        <div class="profile-container">
            <h2>Teacher Profile</h2>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($teacher['fullname']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($teacher['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($teacher['email']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($teacher['phone_number']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($teacher['address']); ?></p>
            <p><strong>Qualifications:</strong> <?php echo htmlspecialchars($teacher['qualifications']); ?></p>
        </div>
    </div>
</body>
</html>
