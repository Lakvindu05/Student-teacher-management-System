<?php
session_start();
include 'db-connect.php';

if (!isset($_SESSION['username'])) {
    header('Location: admin-login.html');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = $_POST['teacher_id'];
    $schedule = $_POST['schedule'];

    $teacher_id = mysqli_real_escape_string($conn, $teacher_id);

    // Prepare and execute the SQL statement to delete existing schedule for the teacher
    $delete_sql = "DELETE FROM TeacherSchedules WHERE teacher_id = '$teacher_id'";
    $conn->query($delete_sql);

    // Prepare and execute the SQL statements to insert the new schedule
    foreach ($schedule as $day => $periods) {
        foreach ($periods as $period => $class) {
            $class = mysqli_real_escape_string($conn, $class);
            $sql = "INSERT INTO TeacherSchedules (teacher_id, day, period, class) VALUES ('$teacher_id', '$day', '$period', '$class')";
            $conn->query($sql);
        }
    }

    echo "Schedule added successfully!";
}

// Fetch all teachers for the dropdown
$teachers_sql = "SELECT id, fullname FROM Teachers";
$teachers_result = $conn->query($teachers_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher Schedules</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            width: 80%;
            margin: auto;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
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
    <?php include 'admin-panel.php'?>
    <div class="content">
        <h2>Add Teacher Schedules</h2>
        <form action="add-teacher-schedules.php" method="post">
            <label for="teacher_id">Select Teacher:</label>
            <select id="teacher_id" name="teacher_id" required>
                <?php
                if ($teachers_result->num_rows > 0) {
                    while($teacher = $teachers_result->fetch_assoc()) {
                        echo "<option value='".$teacher['id']."'>".$teacher['fullname']."</option>";
                    }
                } else {
                    echo "<option value=''>No teachers available</option>";
                }
                ?>
            </select>
            <label for="schedule">Class Schedule:</label>
            <table>
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Period</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    $periods = range(1, 7);
                    foreach ($days as $day) {
                        foreach ($periods as $period) {
                            echo "<tr>";
                            echo "<td>$day</td>";
                            echo "<td>$period</td>";
                            echo "<td><input type='text' name='schedule[$day][$period]'></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <input type="submit" value="Add Schedule">
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>