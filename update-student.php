<?php
session_start();
include 'db-connect.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$update_success = false;
$students = [];
$student = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the student details if a student is selected
    if (isset($_POST['student_id']) && !isset($_POST['name'])) {
        $student_id = $_POST['student_id'];
        $sql = "SELECT * FROM Students WHERE id = $student_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
        }
    }
    // Update the student details
    elseif (isset($_POST['name'])) {
        $student_id = $_POST['student_id'];
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
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Update the student in the database
        $sql = "UPDATE Students SET
            name = '$name',
            username = '$username',
            class = '$class',
            admission_number = '$admission_number',
            class_teacher = '$class_teacher',
            sports = '$sports',
            extra_curricular = '$extra_curricular',
            address = '$address',
            mobile_phone = '$mobile_phone',
            email = '$email',
            password = '$password'
            WHERE id = $student_id";

        if ($conn->query($sql) === TRUE) {
            $update_success = true;
            // Fetch the updated student details
            $sql = "SELECT * FROM Students WHERE id = $student_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $student = $result->fetch_assoc();
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    // Fetch all students for the dropdown
    $sql = "SELECT id, name FROM Students";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
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
    <title>Update Student</title>
</head>
<body>
    <h2>Update Student Details</h2>
    <form action="update-student.php" method="post" style="display: flex; flex-direction: column; width: 80%; margin: auto;">
        <label for="student_id">Select Student:</label>
        <select id="student_id" name="student_id" required>
            <option value="">Select a student</option>
            <?php foreach ($students as $student_option): ?>
                <option value="<?php echo $student_option['id']; ?>"><?php echo htmlspecialchars($student_option['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" value="Select Student">
    </form>
    <?php if ($student && isset($student['id'])): ?>
        <h3>Update <?php echo htmlspecialchars($student['name']); ?>'s Details</h3>
        <?php if ($update_success): ?>
            <p>Student details updated successfully!</p>
        <?php endif; ?>
        <form action="update-student.php" method="post" style="display: flex; flex-direction: column; width: 80%; margin: auto;">
            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($student['username']); ?>" required><br><br>

            <label for="class">Class:</label>
            <input type="text" id="class" name="class" value="<?php echo htmlspecialchars($student['class']); ?>" required><br><br>

            <label for="admission_number">Admission Number:</label>
            <input type="text" id="admission_number" name="admission_number" value="<?php echo htmlspecialchars($student['admission_number']); ?>" required><br><br>

            <label for="class_teacher">Class Teacher:</label>
            <input type="text" id="class_teacher" name="class_teacher" value="<?php echo htmlspecialchars($student['class_teacher']); ?>" required><br><br>

            <label for="sports">Sports:</label>
            <input type="text" id="sports" name="sports" value="<?php echo htmlspecialchars($student['sports']); ?>"><br><br>

            <label for="extra_curricular">Extra Curricular:</label>
            <input type="text" id="extra_curricular" name="extra_curricular" value="<?php echo htmlspecialchars($student['extra_curricular']); ?>"><br><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($student['address']); ?>"><br><br>

            <label for="mobile_phone">Mobile Phone:</label>
            <input type="text" id="mobile_phone" name="mobile_phone" value="<?php echo htmlspecialchars($student['mobile_phone']); ?>" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value=""><br><br>

            <input type="submit" value="Update Student">
        </form>
    <?php endif; ?>
    <br>
    <a href="teacher-panel.php">Back to Teacher Panel</a>
</body>
</html>
