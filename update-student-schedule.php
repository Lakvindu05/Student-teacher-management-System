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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        h3 {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'teacher-panel.php' ?>
    <div class="content">
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
    </div>
</body>
</html>

<?php
$conn->close();
?>
