<?php
session_start();

require_once "db.php";

//protect page
if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}

$message = "";
$id = $_GET["id"] ?? "";

if ($id === "") {
    header("Location: users.php");
    exit;
}

// Get user
$sql = "SELECT id, name, email FROM users WHERE id = ?";

$statement = $connection->prepare($sql);
$statement->execute([$id]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: users.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");

    // Validation
    if ($name === "" || $email === "") {
        $message = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email";
    }

    // Check duplicate email
    if ($message === "") {
        $sql = "SELECT id FROM users WHERE email = ? AND id != ?";

        $statement = $connection->prepare($sql);
        $statement->execute([$email, $id]);
        $existing_user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($existing_user) {
            $message = "Email already exists";
        }
    }

    // Update user
    if ($message === "") {
        $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";

        $statement = $connection->prepare($sql);
        $statement->execute([$name, $email, $id]);

        if ($_SESSION["user_id"] == $id) {
            $_SESSION["user_name"] = $name;
        }

        header("Location: users.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="dashboard-main">
    <div class="container">
        <section class="dashboard-section">
            <h2>Update User</h2>

            <?php if ($message !== ""): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
                </div>

                <button class="btn" type="submit">Update User</button>
                <a class="btn btn-secondary" href="users.php">Cancel</a>
            </form>
        </section>
    </div>
</main>

</body>
</html>
