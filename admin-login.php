<?php
session_start();
include 'db-connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query the database for the user
    $sql = "SELECT id, username, password FROM Admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, now verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['username'] = $username;
            // Redirect to admin panel
            header('Location: admin-panel.php');
            exit();
        } else {
            // Invalid password
            $error_message = "Invalid username or password!";
        }
    } else {
        // Invalid username
        $error_message = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <form action="admin-login.php" method="post" style="display: flex; flex-direction: column; width: 80%; margin: auto;">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
        <br>
        <a href="admin-registration.php" style="text-align: center;">Not Registered? Register here!</a>
    </form>
</body>
</html>
<?php
$conn->close();
?>
