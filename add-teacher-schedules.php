<!-- add-schedules.php -->
<?php
session_start();
include 'db-connect.php';

if (!isset($_SESSION['username'])) {
    header('Location: admin-login.html');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = $_POST['teacher_id'];
    $subject = $_POST['subject'];
    $day = $_POST['day'];
    $time = $_POST['time'];

    $teacher_id = mysqli_real_escape_string($conn, $teacher_id);
    $subject = mysqli_real_escape_string($conn, $subject);
    $day = mysqli_real_escape_string($conn, $day);
    $time = mysqli_real_escape_string($conn, $time);

    $sql = "INSERT INTO Schedules (teacher_id, subject, day, time) VALUES ('$teacher_id', '$subject', '$day', '$time')";
    if ($conn->query($sql) === TRUE) {
        echo "Schedule added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all teachers for the dropdown
$teachers_sql = "SELECT id, name FROM Teachers";
$teachers_result = $conn->query($teachers_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedules</title>
</head>
<body>
    <h1>Add Schedules</h1>
    <form action="add-schedules.php" method="post">
        <label for="teacher_id">Teacher:</label>
        <select id="teacher_id" name="teacher_id" required>
            <?php while ($teacher = $teachers_result->fetch_assoc()) { ?>
                <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
            <?php } ?>
        </select><br><br>
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required><br><br>
        <label for="day">Day:</label>
        <input type="text" id="day" name="day" required><br><br>
        <label for="time">Time:</label>
        <input type="text" id="time" name="time" required><br><br>
        <input type="submit" value="Add Schedule">
    </form>
</body>
</html>
<?php
$conn->close();
?>
