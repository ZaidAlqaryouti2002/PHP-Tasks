<?php
 session_start();
 require_once "db.php";
 require_once "dashboard-oop.php";

if (!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}

//count the users
$dashboard = new Dashboard($connection);

$total_users = $dashboard->countUsers();


// count the products
$total_products = $dashboard->countProducts();

// Get all users
$users = $dashboard->getUsers();

//Get all products
$products = $dashboard->getProducts();
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

        <!-- Display logged in user name -->

        <h1>
            Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>
        </h1>


        <!-- Dashboard counts -->

        <section class="stats">

            <div class="stat-card">

                <h3>Total Users</h3>

                <p>
                    <?= $total_users ?>
                </p>

            </div>


            <div class="stat-card">

                <h3>Total Products</h3>

                <p>
                    <?= $total_products ?>
                </p>

            </div>

        </section>


        <!-- Users table -->

        <section class="dashboard-section">

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

                        <?php foreach ($users as $user): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($user["id"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($user["name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($user["email"]) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </section>


        <!-- Products table -->

        <section class="dashboard-section">

            <h2>Products</h2>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Created Date</th>
                            <th>Category</th>
                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($products as $product): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($product["id"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($product["product_name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($product["description"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($product["price"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($product["create_date"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($product["category"]) ?>
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