<?php

session_start();

require "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Email and password are required";
    }

    if ($error === "") {

        $statement = $con->prepare(
            "SELECT id, name, email, password
             FROM users
             WHERE email = ?"
        );

        $statement->bind_param("s", $email);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];

                header("Location: users.php");
                exit;

            } else {
                $error = "Invalid email or password";
            }

        } else {
            $error = "Invalid email or password";
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

      <?php if ($error !== ""): ?>
        <p class="message message-error">
          <?= htmlspecialchars($error) ?>
        </p>
      <?php endif; ?>

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
        Don't have an account? <a href="register.php">Register</a>
      </div>
    </section>
  </main>

</body>
</html>