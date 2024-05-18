<?php
session_start();
include 'db-connect.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch students for the dropdown
$students_sql = "SELECT id, name FROM Students";
$students_result = $conn->query($students_sql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    // Delete existing schedule for the student
    $delete_sql = "DELETE FROM StudentSchedule WHERE student_id = '$student_id'";
    $conn->query($delete_sql);

    // Insert new schedule
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
    echo "Schedule updated successfully!";
}

// Fetch existing schedule for the selected student
$student_schedule = [];
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $schedule_sql = "SELECT * FROM StudentSchedule WHERE student_id = '$student_id'";
    $schedule_result = $conn->query($schedule_sql);
    while ($row = $schedule_result->fetch_assoc()) {
        $student_schedule[$row['day']][$row['period']] = $row['subject'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Schedule</title>
</head>
<body>
    <h2>Update Student Schedule</h2>
    <form method="get" action="update-student-schedule.php" style="display: flex; flex-direction: column; width: 80%; margin: auto;">
        <label for="student_id">Select Student:</label>
        <select id="student_id" name="student_id" onchange="this.form.submit()" required>
            <option value="">-- Select a Student --</option>
            <?php
            if ($students_result->num_rows > 0) {
                while($student = $students_result->fetch_assoc()) {
                    $selected = isset($student_id) && $student['id'] == $student_id ? 'selected' : '';
                    echo "<option value='".$student['id']."' $selected>".$student['name']."</option>";
                }
            } else {
                echo "<option value=''>No students available</option>";
            }
            ?>
        </select><br><br>
    </form>

    <?php if (isset($student_id)): ?>
    <form action="update-student-schedule.php" method="post" style="display: flex; flex-direction: column; width: 80%; margin: auto;">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
        <?php
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($days as $day) {
            echo "<h3>$day</h3>";
            for ($period = 1; $period <= 7; $period++) {
                $subject_value = isset($student_schedule[$day][$period]) ? htmlspecialchars($student_schedule[$day][$period]) : '';
                echo "<label for='{$day}_period_{$period}'>Period $period:</label>";
                echo "<input type='text' id='{$day}_period_{$period}' name='{$day}_period_{$period}' value='$subject_value' required><br><br>";
            }
        }
        ?>
        <input type="submit" value="Update Schedule">
    </form>
    <?php endif; ?>
</body>
</html>

<?php
$conn->close();
?>
