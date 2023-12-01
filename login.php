<html lang="en">
<?php

if (isset($_GET["error"])) {
    $login_message = $_GET["error"];
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login and Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 300px;
        }

        .form-container {
            position: relative;
            transition: transform 0.3s ease-in-out;
        }

        .form {
            padding: 20px;
            display: none;
            flex-direction: column;
            align-items: center;
        }

        .form h2 {
            margin-bottom: 20px;
        }

        .form input {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: black;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .toggle {
            display: flex;
            justify-content: space-between;
            background-color: #007BFF;
        }

        .toggle button {
            flex: 1;
            padding: 10px;
            border: none;
            color: black;
            cursor: pointer;
        }

        .toggle button.active {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <form id="login-form" class="form" action="auth/login_proses.php" method="POST">
                <h2>Login</h2>
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <form id="register-form" class="form" action="auth/register_proses.php" method="POST" enctype="multipart/form-data">
                <h2>Register</h2>
                <input type="text" name="new-username" placeholder="Username" autocomplete="off" required>
                <input type="password" name="new-password" placeholder="Password" required>
                <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" required>
                <button type="submit">Register</button>
            </form>
        </div>
        <div class="toggle">
            <button id="login-btn" class="active">Login</button>
            <button id="register-btn">Register</button>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>
<script>
    document.getElementById("login-btn").addEventListener("click", function() {
        document.getElementById("login-form").style.display = "flex";
        document.getElementById("register-form").style.display = "none";
        document.getElementById("login-btn").classList.add("active");
        document.getElementById("register-btn").classList.remove("active");
    });

    document.getElementById("register-btn").addEventListener("click", function() {
        document.getElementById("register-form").style.display = "flex";
        document.getElementById("login-form").style.display = "none";
        document.getElementById("register-btn").classList.add("active");
        document.getElementById("login-btn").classList.remove("active");
    });
</script>