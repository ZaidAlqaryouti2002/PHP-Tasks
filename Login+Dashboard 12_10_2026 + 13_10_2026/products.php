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

$product_id = "";
$edit_name = "";
$edit_description = "";
$edit_price = "";
$edit_quantity = "";


// =========================
// 4) PROTECT PAGE
// =========================
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}


// =========================
// 5) DELETE PRODUCT
// =========================
if (isset($_GET["delete"])) {

    $delete_id = $_GET["delete"];

    $statement = $connection->prepare(
        "DELETE FROM products
         WHERE id = ?"
    );

    $statement->bind_param("i", $delete_id);

    if ($statement->execute()) {
        $message = "Product deleted successfully";
    } else {
        $message = "Failed to delete product";
    }
}


// =========================
// 6) GET PRODUCT FOR EDIT
// =========================
if (isset($_GET["edit"])) {

    $product_id = $_GET["edit"];

    $statement = $connection->prepare(
        "SELECT id, product_name, description, price, quantity
         FROM products
         WHERE id = ?"
    );

    $statement->bind_param("i", $product_id);

    $statement->execute();

    $result = $statement->get_result();

    if ($result->num_rows === 1) {

        $product = $result->fetch_assoc();

        $edit_name = $product["product_name"];
        $edit_description = $product["description"];
        $edit_price = $product["price"];
        $edit_quantity = $product["quantity"];
    }
}


// =========================
// 7) HANDLE FORM SUBMISSION
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $product_id = $_POST["product_id"] ?? "";

    $product_name = trim($_POST["product_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = $_POST["price"] ?? "";
    $quantity = $_POST["quantity"] ?? "";


    // =========================
    // 8) VALIDATION
    // =========================
    if (
        $product_name === "" ||
        $description === "" ||
        $price === "" ||
        $quantity === ""
    ) {

        $message = "All fields are required";

    } elseif (!is_numeric($price)) {

        $message = "Price must be a number";

    } elseif (!is_numeric($quantity)) {

        $message = "Quantity must be a number";

    } elseif ($price < 0 || $quantity < 0) {

        $message = "Price and quantity cannot be negative";
    }


    // =========================
    // 9) INSERT OR UPDATE PRODUCT
    // =========================
    if ($message === "") {

        // =========================
        // CREATE PRODUCT
        // =========================
        if ($product_id === "") {

            $statement = $connection->prepare(
                "INSERT INTO products
                (product_name, description, price, quantity)
                VALUES (?, ?, ?, ?)"
            );

            $statement->bind_param(
                "ssdi",
                $product_name,
                $description,
                $price,
                $quantity
            );

            if ($statement->execute()) {

                $message = "Product added successfully";

            } else {

                $message = "Failed to add product";
            }

        }

        // =========================
        // UPDATE PRODUCT
        // =========================
        else {

            $statement = $connection->prepare(
                "UPDATE products
                 SET product_name = ?,
                     description = ?,
                     price = ?,
                     quantity = ?
                 WHERE id = ?"
            );

            $statement->bind_param(
                "ssdii",
                $product_name,
                $description,
                $price,
                $quantity,
                $product_id
            );

            if ($statement->execute()) {

                $message = "Product updated successfully";

                $product_id = "";
                $edit_name = "";
                $edit_description = "";
                $edit_price = "";
                $edit_quantity = "";

            } else {

                $message = "Failed to update product";
            }
        }
    }
}


// =========================
// 10) GET ALL PRODUCTS
// =========================
$products = $connection->query(
    "SELECT id, product_name, description, price, quantity
     FROM products
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Products</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


<header class="dashboard-header">

    <div class="container">

        <h2>Admin Dashboard</h2>

        <nav>

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="users.php">
                Users
            </a>

            <a href="products.php">
                Products
            </a>

            <a href="logout.php">
                Logout
            </a>

        </nav>

    </div>

</header>


<main class="dashboard-main">

    <div class="container">


        <h1 class="page-title">
            Product Management
        </h1>


        <!-- =========================
             11) DISPLAY MESSAGE
        ========================== -->

        <?php if ($message !== ""): ?>

            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>


        <section class="section">

            <div class="two-columns">


                <!-- =========================
                     12) PRODUCT FORM
                ========================== -->

                <div>

                    <h2>Add / Edit Product</h2>

                    <form action="" method="post">


                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= htmlspecialchars($product_id) ?>"
                        >


                        <div class="form-group">

                            <label for="product_name">
                                Product Name
                            </label>

                            <input
                                type="text"
                                id="product_name"
                                name="product_name"
                                value="<?= htmlspecialchars($edit_name) ?>"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                required
                            ><?= htmlspecialchars($edit_description) ?></textarea>

                        </div>


                        <div class="form-group">

                            <label for="price">
                                Price
                            </label>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                step="0.01"
                                min="0"
                                value="<?= htmlspecialchars($edit_price) ?>"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label for="quantity">
                                Quantity
                            </label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                min="0"
                                value="<?= htmlspecialchars($edit_quantity) ?>"
                                required
                            >

                        </div>


                        <button
                            class="btn"
                            type="submit"
                        >
                            Save Product
                        </button>

                    </form>

                </div>


                <!-- =========================
                     13) PRODUCTS TABLE
                ========================== -->

                <div>

                    <h2>Products List</h2>

                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Name</th>

                                    <th>Description</th>

                                    <th>Price</th>

                                    <th>Quantity</th>

                                    <th>Actions</th>

                                </tr>

                            </thead>


                            <tbody>


                            <!-- =========================
                                 14) DISPLAY PRODUCTS LOOP
                            ========================== -->

                            <?php while ($product = $products->fetch_assoc()): ?>


                                <tr>


                                    <td>
                                        <?= $product["id"] ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars($product["product_name"]) ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars($product["description"]) ?>
                                    </td>


                                    <td>
                                        <?= $product["price"] ?>
                                    </td>


                                    <td>
                                        <?= $product["quantity"] ?>
                                    </td>


                                    <td class="actions">


                                        <a
                                            class="btn btn-small btn-secondary"
                                            href="products.php?edit=<?= $product["id"] ?>"
                                        >
                                            Edit
                                        </a>


                                        <a
                                            class="btn btn-small btn-danger"
                                            href="products.php?delete=<?= $product["id"] ?>"
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