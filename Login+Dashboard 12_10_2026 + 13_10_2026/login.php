<?php

// =========================
// START SESSION
// =========================
session_start();

// =========================
// DATABASE CONNECTION
// =========================
require "db.php";

$message = "";

// =========================
// REDIRECT LOGGED-IN USER
// =========================
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

// =========================
// HANDLE LOGIN FORM
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // =========================
    // VALIDATION
    // =========================
    if ($email === "" || $password === "") {
        $message = "All fields are required";
    }

    // =========================
    // FIND USER BY EMAIL
    // =========================
    if ($message === "") {

        $statement = $connection->prepare(
            "SELECT id, name, email, password
             FROM users
             WHERE email = ?"
        );

        $statement->bind_param("s", $email);
        $statement->execute();

        $result = $statement->get_result();

        // =========================
        // VERIFY PASSWORD
        // =========================
        if ($result->num_rows === 1) {

            $member = $result->fetch_assoc();

            if (password_verify($password, $member["password"])) {

                $_SESSION["user_id"] = $member["id"];
                $_SESSION["member_name"] = $member["name"];

                header("Location: dashboard.php");
                exit;

            } else {
                $message = "Invalid login";
            }

        } else {
            $message = "Invalid login";
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
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="auth-page">
    <section class="auth-card">

        <h1>Login</h1>
        <p>Enter your email and password.</p>

        <!-- =========================
             DISPLAY MESSAGE
        ========================== -->
        <?php if ($message !== ""): ?>
            <p class="message message-error">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <!-- =========================
             LOGIN FORM
        ========================== -->
        <form action="" method="post">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button class="btn" type="submit">Login</button>

        </form>

        <div class="auth-link">
            Don't have an account?
            <a href="register.php">Register</a>
        </div>

    </section>
</main>

</body>
</html>
