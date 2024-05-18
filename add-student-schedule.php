<?php
session_start();
include 'db-connect.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    foreach ($days as $day) {
        for ($period = 1; $period <= 7; $period++) {
            $subject = $_POST["{$day}_period_{$period}"];
            $subject = mysqli_real_escape_string($conn, $subject);
            $sql = "INSERT INTO StudentSchedule (student_id, day, period, subject) VALUES ('$student_id', '$day', '$period', '$subject')";
            if (!$conn->query($sql)) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    echo "Schedule added successfully!";
}

// Fetch students for the dropdown
$students_sql = "SELECT id, name FROM Students";
$students_result = $conn->query($students_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Schedule</title>
</head>
<body>
    <h2>Add Student Schedule</h2>
    <form action="add-student-schedule.php" method="post" style="display: flex; flex-direction: column; width: 80%; margin: auto;">
        <label for="student_id">Select Student:</label>
        <select id="student_id" name="student_id" required>
            <?php
            if ($students_result->num_rows > 0) {
                while($student = $students_result->fetch_assoc()) {
                    echo "<option value='".$student['id']."'>".$student['name']."</option>";
                }
            } else {
                echo "<option value=''>No students available</option>";
            }
            ?>
        </select><br><br>
        
        <?php
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        foreach ($days as $day) {
            echo "<h3>$day</h3>";
            for ($period = 1; $period <= 7; $period++) {
                echo "<label for='{$day}_period_{$period}'>Period $period:</label>";
                echo "<input type='text' id='{$day}_period_{$period}' name='{$day}_period_{$period}' required><br><br>";
            }
        }
        ?>

        <input type="submit" value="Add Schedule">
    </form>
</body>
</html>

<?php
$conn->close();
?>
