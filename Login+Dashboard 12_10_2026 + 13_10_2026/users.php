<?php

session_start();

require "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";
$editUser = null;

/* Delete user */
if (isset($_GET["delete"])) {

    $userId = (int) $_GET["delete"];

    $statement = $con->prepare("DELETE FROM users WHERE id = ?");
    $statement->bind_param("i", $userId);

    if ($statement->execute()) {
        $success = "User deleted successfully";
    } else {
        $error = "Failed to delete user";
    }
}

/* Get user data for editing */
if (isset($_GET["edit"])) {

    $userId = (int) $_GET["edit"];

    $statement = $con->prepare(
        "SELECT id, name, email
         FROM users
         WHERE id = ?"
    );

    $statement->bind_param("i", $userId);
    $statement->execute();

    $result = $statement->get_result();
    $editUser = $result->fetch_assoc();
}

/* Add or update user */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $userId = $_POST["user_id"] ?? "";

    if ($name === "" || $email === "") {
        $error = "Name and email are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email";
    }

    /* Update existing user */
    if ($error === "" && $userId !== "") {

        $userId = (int) $userId;

        $statement = $con->prepare(
            "SELECT id
             FROM users
             WHERE email = ? AND id != ?"
        );

        $statement->bind_param("si", $email, $userId);
        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already exists";
        } else {

            if ($password !== "") {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $statement = $con->prepare(
                    "UPDATE users
                     SET name = ?, email = ?, password = ?
                     WHERE id = ?"
                );

                $statement->bind_param(
                    "sssi",
                    $name,
                    $email,
                    $hashedPassword,
                    $userId
                );

            } else {

                $statement = $con->prepare(
                    "UPDATE users
                     SET name = ?, email = ?
                     WHERE id = ?"
                );

                $statement->bind_param("ssi", $name, $email, $userId);
            }

            if ($statement->execute()) {
                $success = "User updated successfully";
                $editUser = null;
            } else {
                $error = "Failed to update user";
            }
        }
    }

    /* Add new user */
    elseif ($error === "") {

        if ($password === "") {
            $error = "Password is required";
        } else {

            $statement = $con->prepare(
                "SELECT id FROM users WHERE email = ?"
            );

            $statement->bind_param("s", $email);
            $statement->execute();

            $result = $statement->get_result();

            if ($result->num_rows > 0) {
                $error = "Email already exists";
            } else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $statement = $con->prepare(
                    "INSERT INTO users (name, email, password)
                     VALUES (?, ?, ?)"
                );

                $statement->bind_param(
                    "sss",
                    $name,
                    $email,
                    $hashedPassword
                );

                if ($statement->execute()) {
                    $success = "User added successfully";
                } else {
                    $error = "Failed to add user";
                }
            }
        }
    }
}

$users = $con->query(
    "SELECT id, name, email
     FROM users
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="dashboard-header">
    <div class="container">
      <h2>Admin Dashboard</h2>

      <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="products.php">Products</a>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main class="dashboard-main">
    <div class="container">

      <h1 class="page-title">User Management</h1>

      <?php if ($error !== ""): ?>
        <p class="message message-error">
          <?= htmlspecialchars($error) ?>
        </p>
      <?php endif; ?>

      <?php if ($success !== ""): ?>
        <p class="message message-success">
          <?= htmlspecialchars($success) ?>
        </p>
      <?php endif; ?>

      <section class="section">
        <div class="two-columns">

          <div>
            <h2><?= $editUser ? "Edit User" : "Add User" ?></h2>

            <form action="" method="post">

              <input
                type="hidden"
                name="user_id"
                value="<?= $editUser["id"] ?? "" ?>"
              >

              <div class="form-group">
                <label for="name">Name</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  value="<?= htmlspecialchars($editUser["name"] ?? "") ?>"
                  required
                >
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  value="<?= htmlspecialchars($editUser["email"] ?? "") ?>"
                  required
                >
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
              </div>

              <button class="btn" type="submit">
                <?= $editUser ? "Update User" : "Add User" ?>
              </button>
            </form>
          </div>

          <div>
            <h2>Registered Users</h2>

            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                      <td><?= $user["id"] ?></td>
                      <td><?= htmlspecialchars($user["name"]) ?></td>
                      <td><?= htmlspecialchars($user["email"]) ?></td>
                      <td class="actions">
                        <a
                          class="btn btn-small btn-secondary"
                          href="users.php?edit=<?= $user["id"] ?>"
                        >Edit</a>

                        <a
                          class="btn btn-small btn-danger"
                          href="users.php?delete=<?= $user["id"] ?>"
                        >Delete</a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </section>
    </div>
  </main>

</body>
</html>
