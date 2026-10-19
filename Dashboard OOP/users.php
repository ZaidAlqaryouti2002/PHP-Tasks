<?php
session_start();

require_once "db.php";

//protect page
if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}

// Get all users
$sql = "SELECT id, name, email FROM users";

$statement = $connection->query($sql);

$users = $statement->fetchAll(PDO::FETCH_ASSOC);

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
        <h2>Dashboard</h2>
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

        <section class="dashboard-section">
            <h2>Users</h2>

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

                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user["id"]) ?></td>
                                <td><?= htmlspecialchars($user["name"]) ?></td>
                                <td><?= htmlspecialchars($user["email"]) ?></td>
                                <td class="actions">
                                    <a class="btn btn-small btn-secondary" href="update_user.php?id=<?= $user["id"] ?>">Update</a>
                                    <a class="btn btn-small btn-danger" href="delete_user.php?id=<?= $user["id"] ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>

</body>
</html>
