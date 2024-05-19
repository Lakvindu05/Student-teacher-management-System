<?php
session_start();
include 'db-connect.php';

if (!isset($_SESSION['username'])) {
    header('Location: admin-login.html');
    exit();
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM Admin WHERE username = '$username'";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .profile {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .profile h1 {
            margin-top: 0;
        }
        .profile p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <?php include 'admin-panel.php'?>
    <div class="content">
        <div class="profile">
            <h1>Profile</h1>
            <p>Username: <?php echo $admin['username']; ?></p>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
