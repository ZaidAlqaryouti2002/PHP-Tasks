<?php

session_start();

require "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userResult = $con->query("SELECT COUNT(*) AS total_users FROM users");
$userCount = $userResult->fetch_assoc();

$productResult = $con->query("SELECT COUNT(*) AS total_products FROM products");
$productCount = $productResult->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        <h1 class="page-title">
            Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>
        </h1>

        <section class="stats">
            <article class="stat-card">
                <h3>Total Users</h3>
                <strong><?= $userCount["total_users"] ?></strong>
            </article>

            <article class="stat-card">
                <h3>Total Products</h3>
                <strong><?= $productCount["total_products"] ?></strong>
            </article>
        </section>

        <section class="section">
            <div class="section-header">
                <div>
                    <h2>User Management</h2>
                    <p>View, add, edit and delete users.</p>
                </div>

                <a class="btn" href="users.php">Manage Users</a>
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <div>
                    <h2>Product Management</h2>
                    <p>View, add, edit and delete products.</p>
                </div>

                <a class="btn" href="products.php">Manage Products</a>
            </div>
        </section>

    </div>
</main>

</body>
</html>
