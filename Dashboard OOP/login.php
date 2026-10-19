<?php

session_start();

require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validation
    if ($email === "" || $password === "") {
        $message = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email";
    }

    // Login check
    if ($message === "") {

        $sql = "SELECT id, name, email, password
                FROM users
                WHERE email = ?";

        $statement = $connection->prepare($sql);

        $statement->execute([
            $email
        ]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user["password"])) {

            // Save session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: dashboard.php");
            exit;

        } else {
            $message = "Invalid email or password";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;

            background-color: white;
            padding: 30px;

            border-radius: 12px;

            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }

        .login-card h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        .login-card p {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        .message {
            background-color: #ffe5e5;
            color: #b00020;

            padding: 10px;
            margin-bottom: 15px;

            border-radius: 6px;

            text-align: center;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;

            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;

            padding: 11px;

            border: 1px solid #ccc;
            border-radius: 7px;

            font-size: 15px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #e65f00;
        }

        .login-button {
            width: 100%;

            padding: 12px;

            border: none;
            border-radius: 7px;

            background-color: #e65f00;
            color: white;

            font-size: 16px;
            font-weight: bold;

            cursor: pointer;
        }

        .login-button:hover {
            background-color: #cc5400;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #e65f00;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <main class="login-card">

        <h1>Login</h1>

        <p>Enter your email and password</p>

        <?php if ($message !== ""): ?>

            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>

        <form action="" method="post">

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >

            </div>

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

            </div>

            <button
                type="submit"
                class="login-button"
            >
                Login
            </button>

        </form>

        <div class="register-link">

            Don't have an account?

            <a href="register.php">
                Register
            </a>

        </div>

    </main>

</body>

</html>