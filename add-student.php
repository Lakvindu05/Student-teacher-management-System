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

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $class = $_POST['class'];
    $admission_number = $_POST['admission_number'];
    $class_teacher = $_POST['class_teacher'];
    $sports = $_POST['sports'];
    $extra_curricular = $_POST['extra_curricular'];
    $address = $_POST['address'];
    $mobile_phone = $_POST['mobile_phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $name = mysqli_real_escape_string($conn, $name);
    $username = mysqli_real_escape_string($conn, $username);
    $class = mysqli_real_escape_string($conn, $class);
    $admission_number = mysqli_real_escape_string($conn, $admission_number);
    $class_teacher = mysqli_real_escape_string($conn, $class_teacher);
    $sports = mysqli_real_escape_string($conn, $sports);
    $extra_curricular = mysqli_real_escape_string($conn, $extra_curricular);
    $address = mysqli_real_escape_string($conn, $address);
    $mobile_phone = mysqli_real_escape_string($conn, $mobile_phone);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT id FROM Students WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Username already exists
        $message = "Username already taken!";
    } else {
        // Insert the new student into the database
        $sql = "INSERT INTO Students (name, username, class, admission_number, class_teacher, sports, extra_curricular, address, mobile_phone, email, password) VALUES ('$name', '$username', '$class', '$admission_number', '$class_teacher', '$sports', '$extra_curricular', '$address', '$mobile_phone', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            $message = "Student added successfully!";
            header('Location: teacher-panel.php');
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
    <title>Add Student</title>
</head>
<body>
    <h2>Add Student</h2>
    <?php
    if (!empty($message)) {
        echo "<p style='color: red;'>$message</p>";
    }
    ?>
    <form action="add-student.php" method="post" style="display: flex; flex-direction: column; width: 80%; margin: auto;">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="class">Class:</label>
        <input type="text" id="class" name="class" required><br><br>
        <label for="admission_number">Admission Number:</label>
        <input type="text" id="admission_number" name="admission_number" required><br><br>
        <label for="class_teacher">Class Teacher:</label>
        <input type="text" id="class_teacher" name="class_teacher" required><br><br>
        <label for="sports">Sports:</label>
        <input type="text" id="sports" name="sports" required><br><br>
        <label for="extra_curricular">Extra Curricular:</label>
        <input type="text" id="extra_curricular" name="extra_curricular" required><br><br>
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea><br><br>
        <label for="mobile_phone">Mobile Phone:</label>
        <input type="text" id="mobile_phone" name="mobile_phone" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Add Student">
    </form>
</body>
</html>
