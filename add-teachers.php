<?php
session_start();
include 'db-connect.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $qualifications = $_POST['qualifications'];

    // Prevent SQL injection
    $fullname = mysqli_real_escape_string($conn, $fullname);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email);
    $phone_number = mysqli_real_escape_string($conn, $phone_number);
    $address = mysqli_real_escape_string($conn, $address);
    $qualifications = mysqli_real_escape_string($conn, $qualifications);

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT id FROM Teachers WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Username already exists
        $message = "Username already taken!";
    } else {
        // Insert the new teacher into the database
        $sql = "INSERT INTO Teachers (fullname, username, password, email, phone_number, address, qualifications) VALUES ('$fullname', '$username', '$hashed_password', '$email', '$phone_number', '$address', '$qualifications')";
        if ($conn->query($sql) === TRUE) {
            $message = "Teacher added successfully!";
            header('Location: admin-panel.php');
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111;
            padding-top: 20px;
            color: white;
        }
        .sidebar h1 {
            padding: 10px;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #444;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar li {
            margin-bottom: 10px;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #333;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .message {
            color: red;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 60%;
            margin: auto;
        }
        label {
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        textarea {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'admin-panel.php'?>
    <div class="content">
        <h2>Add Teacher</h2>
        <?php
        if (!empty($message)) {
            echo "<p style='color: red;'>$message</p>";
        }
        ?>
        <form action="add-teachers.php" method="post" style="display: flex; flex-direction: column; width: 60%; margin: auto;">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required><br><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required><br><br>
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea><br><br>
            <label for="qualifications">Qualifications:</label>
            <textarea id="qualifications" name="qualifications" required></textarea><br><br>
            <input type="submit" value="Add Teacher">
        </form>
    </div>
</body>
</html>
