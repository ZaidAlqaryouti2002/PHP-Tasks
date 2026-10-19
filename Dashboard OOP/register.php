<?php

require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validation
    if ($name === "" || $email === "" || $password === "") {

        $message = "All fields are required";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email";
    }

    // Check duplicate email
    if ($message === "") {

        $sql = "SELECT id FROM users WHERE email = ?";

        $statement = $connection->prepare($sql);

        $statement->execute([
            $email
        ]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $message = "Email already exists";
        }
    }

    // Insert user
    if ($message === "") {

        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)";

        $statement = $connection->prepare($sql);

        $statement->execute([
            $name,
            $email,
            $hashed_password
        ]);

        $message = "Registration successful";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

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

        .register-card {
            width: 100%;
            max-width: 420px;

            background-color: white;
            padding: 30px;

            border-radius: 12px;

            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }

        .register-card h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        .register-card p {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        .message {
            background-color: #fff3cd;
            color: #664d03;

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

        .register-button {
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

        .register-button:hover {
            background-color: #cc5400;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #e65f00;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

<main class="register-card">

    <h1>Create Account</h1>

    <p>Register a new account</p>

    <?php if ($message !== ""): ?>

        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>


    <form action="" method="post">

        <div class="form-group">

            <label for="name">
                Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                required
            >

        </div>


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
            class="register-button"
        >
            Register
        </button>

    </form>


    <div class="login-link">

        Already have an account?

        <a href="login.php">
            Login
        </a>

    </div>

</main>

</body>

</html>