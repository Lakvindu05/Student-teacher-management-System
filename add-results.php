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
    $term = $_POST['term'];
    $subjects = $_POST['subjects'];

    // Delete existing results for the student for the selected term
    $delete_sql = "DELETE FROM Results WHERE student_id = '$student_id' AND term = '$term'";
    $conn->query($delete_sql);

    // Insert new results
    foreach ($subjects as $subject => $marks) {
        $subject = mysqli_real_escape_string($conn, $subject);
        $marks = mysqli_real_escape_string($conn, $marks);
        $sql = "INSERT INTO Results (student_id, term, subject, marks) VALUES ('$student_id', '$term', '$subject', '$marks')";
        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    echo "Results added/updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Results</title>
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
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
        }
        select, input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
    <?php include 'teacher-panel.php'?>
    <div class="content">
        <h2>Add Results</h2>
        <form method="post" action="add-results.php" style="display: flex; flex-direction: column; width: 80%; margin: auto;">
            <label for="student_id">Select Student:</label>
            <select id="student_id" name="student_id" required>
                <option value="">-- Select a Student --</option>
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
    
            <label for="term">Select Term:</label>
            <select id="term" name="term" required>
                <option value="1">Term 1</option>
                <option value="2">Term 2</option>
                <option value="3">Term 3</option>
            </select><br><br>
    
            <?php
            $subjects = ["Math", "Science", "English", "History", "Geography", "Art", "Physical Education"];
            foreach ($subjects as $subject) {
                echo "<label for='subject_$subject'>$subject:</label>";
                echo "<input type='number' id='subject_$subject' name='subjects[$subject]' required><br><br>";
            }
            ?>
    
            <input type="submit" value="Add Results">
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
