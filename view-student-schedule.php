<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_username'])) {
    header('Location: student-login.php');
    exit();
}

// Include the database connection
include 'db-connect.php';

// Get the student's ID and schedule from the database
$username = $_SESSION['student_username'];
$sql = "SELECT id FROM Students WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $student_id = $student['id'];

    // Fetch the student's schedule
    $sql = "
        SELECT day, period, subject
        FROM StudentSchedule
        WHERE student_id = $student_id
        ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), period;
    ";
    $schedule_result = $conn->query($sql);
    
    // Initialize schedule array
    $schedule = [
        'Monday' => [],
        'Tuesday' => [],
        'Wednesday' => [],
        'Thursday' => [],
        'Friday' => []
    ];
    
    if ($schedule_result->num_rows > 0) {
        while ($row = $schedule_result->fetch_assoc()) {
            $schedule[$row['day']][$row['period']] = $row['subject'];
        }
    }
} else {
    echo "Student not found!";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedule</title>
    <style>
        .content {
            width: 80%;
            margin: auto;
            text-align: center;
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
    </style>
</head>
<body>
    <?php include 'student-panel.php'?>
    <div class="content">
        <h1>Your Schedule</h1>
        <table>
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($period = 1; $period <= 7; $period++): ?>
                    <tr>
                        <td><?php echo $period; ?></td>
                        <td><?php echo isset($schedule['Monday'][$period]) ? htmlspecialchars($schedule['Monday'][$period]) : 'Free'; ?></td>
                        <td><?php echo isset($schedule['Tuesday'][$period]) ? htmlspecialchars($schedule['Tuesday'][$period]) : 'Free'; ?></td>
                        <td><?php echo isset($schedule['Wednesday'][$period]) ? htmlspecialchars($schedule['Wednesday'][$period]) : 'Free'; ?></td>
                        <td><?php echo isset($schedule['Thursday'][$period]) ? htmlspecialchars($schedule['Thursday'][$period]) : 'Free'; ?></td>
                        <td><?php echo isset($schedule['Friday'][$period]) ? htmlspecialchars($schedule['Friday'][$period]) : 'Free'; ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        <br>
        <a href="student-panel.php">Back to Dashboard</a>
    </div>
</body>
</html>
