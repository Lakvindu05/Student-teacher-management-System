<!-- admin-profile.php -->
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
</head>
<body>
    <h1>Profile</h1>
    <p>Username: <?php echo $admin['username']; ?></p>
</body>
</html>
<?php
$conn->close();
?>
