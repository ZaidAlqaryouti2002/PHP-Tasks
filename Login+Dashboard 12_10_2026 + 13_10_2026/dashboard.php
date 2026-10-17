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
// 3) PROTECT PAGE
// =========================
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// =========================
// 4) COUNT USERS
// =========================
$userResult = $connection->query(
    "SELECT COUNT(*) AS total_users
     FROM users"
);

$userData = $userResult->fetch_assoc();
$total_users = $userData["total_users"];

// =========================
// 5) COUNT PRODUCTS
// =========================
$productResult = $connection->query(
    "SELECT COUNT(*) AS total_products
     FROM products"
);

$productData = $productResult->fetch_assoc();
$total_products = $productData["total_products"];

// =========================
// 6) GET ALL USERS
// =========================
$users = $connection->query(
    "SELECT id, name, email
     FROM users
     ORDER BY id DESC"
);

// =========================
// 7) GET ALL PRODUCTS
// =========================
$products = $connection->query(
    "SELECT id, product_name, price, quantity
     FROM products
     ORDER BY id DESC"
);

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

        <!-- =========================
             8) WELCOME MESSAGE
        ========================== -->
        <h1 class="page-title">
            Welcome, <?= htmlspecialchars($_SESSION["member_name"]) ?>
        </h1>

        <!-- =========================
             9) DASHBOARD COUNTS
        ========================== -->
        <section class="dashboard-cards">

            <div class="dashboard-card">
                <h3>Total Users</h3>
                <p><?= $total_users ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Total Products</h3>
                <p><?= $total_products ?></p>
            </div>

        </section>

        <!-- =========================
             10) USERS TABLE
        ========================== -->
        <section class="section">

            <h2>Users</h2>

            <div class="table-wrapper">
                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?= $user["id"] ?></td>
                            <td><?= htmlspecialchars($user["name"]) ?></td>
                            <td><?= htmlspecialchars($user["email"]) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>

                </table>
            </div>

        </section>

        <!-- =========================
             11) PRODUCTS TABLE
        ========================== -->
        <section class="section">

            <h2>Products</h2>

            <div class="table-wrapper">
                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <tr>
                            <td><?= $product["id"] ?></td>
                            <td><?= htmlspecialchars($product["product_name"]) ?></td>
                            <td><?= $product["price"] ?></td>
                            <td><?= $product["quantity"] ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>

                </table>
            </div>

        </section>

    </div>
</main>

</body>
</html>
