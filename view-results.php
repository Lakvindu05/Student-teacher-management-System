<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_username'])) {
    header('Location: student-login.php');
    exit();
}

// Include the database connection
include 'db-connect.php';

// Get the student's ID and results from the database
$username = $_SESSION['student_username'];
$sql = "SELECT id FROM Students WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $student_id = $student['id'];

    // Fetch the student's results
    $sql = "
        SELECT subject, term, marks
        FROM Results
        WHERE student_id = $student_id
        ORDER BY subject, term;
    ";
    $results = $conn->query($sql);
    
    // Initialize results array
    $result_data = [];
    
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            $result_data[$row['subject']][$row['term']] = $row['marks'];
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
    <title>View Results</title>
    <style>
        .container {
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
    <div class="container">
        <h1>Your Results</h1>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>1st Term Marks</th>
                    <th>2nd Term Marks</th>
                    <th>3rd Term Marks</th>
                    <th>Difference (1st to 2nd)</th>
                    <th>Difference (2nd to 3rd)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result_data as $subject => $terms): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subject); ?></td>
                        <td><?php echo isset($terms[1]) ? htmlspecialchars($terms[1]) : 'N/A'; ?></td>
                        <td><?php echo isset($terms[2]) ? htmlspecialchars($terms[2]) : 'N/A'; ?></td>
                        <td><?php echo isset($terms[3]) ? htmlspecialchars($terms[3]) : 'N/A'; ?></td>
                        <td>
                            <?php 
                                if (isset($terms[1]) && isset($terms[2])) {
                                    echo htmlspecialchars($terms[2] - $terms[1]);
                                } else {
                                    echo 'N/A';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (isset($terms[2]) && isset($terms[3])) {
                                    echo htmlspecialchars($terms[3] - $terms[2]);
                                } else {
                                    echo 'N/A';
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a href="student-panel.php">Back to Dashboard</a>
    </div>
</body>
</html>
