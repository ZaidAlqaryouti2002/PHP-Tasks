<?php

session_start();

require "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";
$editProduct = null;

/* Delete product */
if (isset($_GET["delete"])) {

    $productId = (int) $_GET["delete"];

    $statement = $con->prepare("DELETE FROM products WHERE id = ?");
    $statement->bind_param("i", $productId);

    if ($statement->execute()) {
        $success = "Product deleted successfully";
    } else {
        $error = "Failed to delete product";
    }
}

/* Get product data for editing */
if (isset($_GET["edit"])) {

    $productId = (int) $_GET["edit"];

    $statement = $con->prepare(
        "SELECT * FROM products WHERE id = ?"
    );

    $statement->bind_param("i", $productId);
    $statement->execute();

    $result = $statement->get_result();
    $editProduct = $result->fetch_assoc();
}

/* Add or update product */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $productName = trim($_POST["product_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = $_POST["price"] ?? "";
    $quantity = $_POST["quantity"] ?? "";
    $productId = $_POST["product_id"] ?? "";

    if (
        $productName === "" ||
        $description === "" ||
        $price === "" ||
        $quantity === ""
    ) {
        $error = "All fields are required";
    } elseif (!is_numeric($price) || $price < 0) {
        $error = "Price must be a valid positive number";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Quantity must be a valid positive number";
    }

    if ($error === "") {

        /* Update existing product */
        if ($productId !== "") {

            $productId = (int) $productId;
            $quantity = (int) $quantity;
            $price = (float) $price;

            $statement = $con->prepare(
                "UPDATE products
                 SET product_name = ?, description = ?, price = ?, quantity = ?
                 WHERE id = ?"
            );

            $statement->bind_param(
                "ssdii",
                $productName,
                $description,
                $price,
                $quantity,
                $productId
            );

            if ($statement->execute()) {
                $success = "Product updated successfully";
                $editProduct = null;
            } else {
                $error = "Failed to update product";
            }

        /* Add new product */
        } else {

            $quantity = (int) $quantity;
            $price = (float) $price;

            $statement = $con->prepare(
                "INSERT INTO products
                 (product_name, description, price, quantity)
                 VALUES (?, ?, ?, ?)"
            );

            $statement->bind_param(
                "ssdi",
                $productName,
                $description,
                $price,
                $quantity
            );

            if ($statement->execute()) {
                $success = "Product added successfully";
            } else {
                $error = "Failed to add product";
            }
        }
    }
}

$products = $con->query(
    "SELECT * FROM products ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
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

      <h1 class="page-title">Product Management</h1>

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
            <h2><?= $editProduct ? "Edit Product" : "Add Product" ?></h2>

            <form action="" method="post">

              <input
                type="hidden"
                name="product_id"
                value="<?= $editProduct["id"] ?? "" ?>"
              >

              <div class="form-group">
                <label for="product_name">Product Name</label>
                <input
                  type="text"
                  id="product_name"
                  name="product_name"
                  value="<?= htmlspecialchars($editProduct["product_name"] ?? "") ?>"
                  required
                >
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea
                  id="description"
                  name="description"
                  required
                ><?= htmlspecialchars($editProduct["description"] ?? "") ?></textarea>
              </div>

              <div class="form-group">
                <label for="price">Price</label>
                <input
                  type="number"
                  id="price"
                  name="price"
                  step="0.01"
                  min="0"
                  value="<?= htmlspecialchars($editProduct["price"] ?? "") ?>"
                  required
                >
              </div>

              <div class="form-group">
                <label for="quantity">Quantity</label>
                <input
                  type="number"
                  id="quantity"
                  name="quantity"
                  min="0"
                  value="<?= htmlspecialchars($editProduct["quantity"] ?? "") ?>"
                  required
                >
              </div>

              <button class="btn" type="submit">
                <?= $editProduct ? "Update Product" : "Add Product" ?>
              </button>
            </form>
          </div>

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
                    <th>Created Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <?php while ($product = $products->fetch_assoc()): ?>
                    <tr>
                      <td><?= $product["id"] ?></td>
                      <td><?= htmlspecialchars($product["product_name"]) ?></td>
                      <td><?= htmlspecialchars($product["description"]) ?></td>
                      <td><?= htmlspecialchars($product["price"]) ?></td>
                      <td><?= htmlspecialchars($product["quantity"]) ?></td>
                      <td>
                        <?= htmlspecialchars(
                          $product["created_date"] ??
                          $product["create_date"] ??
                          ""
                        ) ?>
                      </td>
                      <td class="actions">
                        <a
                          class="btn btn-small btn-secondary"
                          href="products.php?edit=<?= $product["id"] ?>"
                        >Edit</a>

                        <a
                          class="btn btn-small btn-danger"
                          href="products.php?delete=<?= $product["id"] ?>"
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
