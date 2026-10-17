<?php

// =========================
// 1) START SESSION
// =========================
session_start();

// =========================
// 2) DATABASE CONNECTION
// =========================
require "db.php";

// =========================
// 3) INITIAL VARIABLES
// =========================
$message = "";

$user_id = "";
$edit_name = "";
$edit_email = "";

// =========================
// 4) PROTECT PAGE
// =========================
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// =========================
// 5) DELETE USER
// =========================
if (isset($_GET["delete"])) {

    $delete_id = $_GET["delete"];

    $statement = $connection->prepare(
        "DELETE FROM users
         WHERE id = ?"
    );

    $statement->bind_param("i", $delete_id);

    if ($statement->execute()) {
        $message = "User deleted successfully";
    } else {
        $message = "Failed to delete user";
    }
}

// =========================
// 6) GET USER FOR EDIT
// =========================
if (isset($_GET["edit"])) {

    $user_id = $_GET["edit"];

    $statement = $connection->prepare(
        "SELECT id, name, email
         FROM users
         WHERE id = ?"
    );

    $statement->bind_param("i", $user_id);
    $statement->execute();

    $result = $statement->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        $edit_name = $user["name"];
        $edit_email = $user["email"];
    }
}

// =========================
// 7) HANDLE FORM SUBMISSION
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_POST["user_id"] ?? "";

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // =========================
    // 8) VALIDATION
    // =========================
    if ($name === "" || $email === "") {
        $message = "Name and email are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email";
    } elseif ($user_id === "" && $password === "") {
        $message = "Password is required for new users";
    }

    // =========================
    // 9) CHECK DUPLICATE EMAIL
    // =========================
    if ($message === "") {

        if ($user_id === "") {

            $statement = $connection->prepare(
                "SELECT id
                 FROM users
                 WHERE email = ?"
            );

            $statement->bind_param(
                "s",
                $email
            );

        } else {

            $statement = $connection->prepare(
                "SELECT id
                 FROM users
                 WHERE email = ?
                 AND id != ?"
            );

            $statement->bind_param(
                "si",
                $email,
                $user_id
            );
        }

        $statement->execute();

        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already exists";
        }
    }

    // =========================
    // 10) INSERT OR UPDATE USER
    // =========================
    if ($message === "") {

        // =========================
        // CREATE USER
        // =========================
        if ($user_id === "") {

            $securePassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $statement = $connection->prepare(
                "INSERT INTO users
                (name, email, password)
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
                $message = "Failed to add user";
            }

        // =========================
        // UPDATE USER
        // =========================
        } else {

            // =========================
            // UPDATE WITH NEW PASSWORD
            // =========================
            if ($password !== "") {

                $securePassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $statement = $connection->prepare(
                    "UPDATE users
                     SET name = ?,
                         email = ?,
                         password = ?
                     WHERE id = ?"
                );

                $statement->bind_param(
                    "sssi",
                    $name,
                    $email,
                    $securePassword,
                    $user_id
                );

            // =========================
            // UPDATE WITHOUT PASSWORD CHANGE
            // =========================
            } else {

                $statement = $connection->prepare(
                    "UPDATE users
                     SET name = ?,
                         email = ?
                     WHERE id = ?"
                );

                $statement->bind_param(
                    "ssi",
                    $name,
                    $email,
                    $user_id
                );
            }

            if ($statement->execute()) {
                $message = "User updated successfully";

                $user_id = "";
                $edit_name = "";
                $edit_email = "";
            } else {
                $message = "Failed to update user";
            }
        }
    }
}

// =========================
// 11) GET ALL USERS
// =========================
$users = $connection->query(
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

        <!-- =========================
             12) DISPLAY MESSAGE
        ========================== -->
        <?php if ($message !== ""): ?>
            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <section class="section">
            <div class="two-columns">

                <!-- =========================
                     13) USER FORM
                ========================== -->
                <div>

                    <h2>Add / Edit User</h2>

                    <form action="" method="post">

                        <input
                            type="hidden"
                            name="user_id"
                            value="<?= htmlspecialchars($user_id) ?>"
                        >

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="<?= htmlspecialchars($edit_name) ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="<?= htmlspecialchars($edit_email) ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                            >
                        </div>

                        <button class="btn" type="submit">
                            Save User
                        </button>

                    </form>

                </div>

                <!-- =========================
                     14) USERS TABLE
                ========================== -->
                <div>

                    <h2>Users List</h2>

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

                            <!-- =========================
                                 15) DISPLAY USERS LOOP
                            ========================== -->
                            <?php while ($user = $users->fetch_assoc()): ?>

                                <tr>
                                    <td><?= $user["id"] ?></td>
                                    <td><?= htmlspecialchars($user["name"]) ?></td>
                                    <td><?= htmlspecialchars($user["email"]) ?></td>

                                    <td class="actions">
                                        <a
                                            class="btn btn-small btn-secondary"
                                            href="users.php?edit=<?= $user["id"] ?>"
                                        >
                                            Edit
                                        </a>

                                        <a
                                            class="btn btn-small btn-danger"
                                            href="users.php?delete=<?= $user["id"] ?>"
                                        >
                                            Delete
                                        </a>
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
