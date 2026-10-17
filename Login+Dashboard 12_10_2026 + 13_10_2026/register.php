<?php

// =========================
// DATABASE CONNECTION
// =========================
require "db.php";

$message = "";

// =========================
// HANDLE FORM SUBMISSION
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // =========================
    // VALIDATION
    // =========================
    if ($name === "" || $email === "" || $password === "") {
        $message = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email";
    }

    // =========================
    // CHECK DUPLICATE EMAIL
    // =========================
    if ($message === "") {

        $statement = $connection->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $statement->bind_param("s", $email);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already exists";
        }
    }

    // =========================
    // HASH PASSWORD AND INSERT USER
    // =========================
    if ($message === "") {

        $securePassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $statement = $connection->prepare(
            "INSERT INTO users (name, email, password)
             VALUES (?, ?, ?)"
        );

        $statement->bind_param(
            "sss",
            $name,
            $email,
            $securePassword
        );

        if ($statement->execute()) {
            $message = "User added successfully";
        } else {
            $message = "Something went wrong";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="auth-page">
    <section class="auth-card">

        <h1>Create Account</h1>
        <p>Register a new user account.</p>

        <!-- =========================
             DISPLAY MESSAGE
        ========================== -->
        <?php if ($message !== ""): ?>
            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <!-- =========================
             REGISTER FORM
        ========================== -->
        <form action="" method="post">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button class="btn" type="submit">Register</button>

        </form>

        <div class="auth-link">
            Already have an account?
            <a href="login.php">Login</a>
        </div>

    </section>
</main>

</body>
</html>
