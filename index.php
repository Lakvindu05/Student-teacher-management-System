<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h2 {
            margin-bottom: 20px;
        }
        .login-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-buttons a {
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            text-align: center;
            width: 150px;
        }
    </style>
</head>
<body>
    <h2>Welcome to Maris Stella DB</h2>
    <div class="login-buttons">
        <a href="admin-login.php">Admin Login</a>
        <a href="teacher-login.php">Teacher Login</a>
    </div>
</body>
</html>
