<?php
session_start();
include 'db-connect.php';

// Fetch announcements
$announcements_sql = "SELECT id, title, content FROM Announcements ORDER BY created_at DESC";
$announcements_result = $conn->query($announcements_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
</head>
<body>
    <h2>View Announcements</h2>
    <div style="width: 80%; margin: auto;">
        <?php
        if ($announcements_result->num_rows > 0) {
            while($announcement = $announcements_result->fetch_assoc()) {
                echo "<div style='margin-bottom: 20px;'>";
                echo "<h3 onclick='toggleContent(\"content_".$announcement['id']."\")' style='cursor: pointer;'>".$announcement['title']."</h3>";
                echo "<div id='content_".$announcement['id']."' style='display:none;'>".$announcement['content']."</div>";
                echo "</div>";
            }
        } else {
            echo "No announcements available";
        }
        ?>
    </div>
    <script>
        function toggleContent(id) {
            var element = document.getElementById(id);
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
