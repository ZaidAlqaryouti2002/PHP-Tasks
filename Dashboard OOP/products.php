<?php
session_start();

require_once "db.php";

//protect page

if(!isset($_SESSION["user_id"])){
      header("Location: login.php");
      exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
 $product_name= trim($_POST["product_name"] ?? "");
 $description = trim($_POST ["description"] ?? "");
 $price = $_POST["price"] ?? "";
 $quantity = $_POST["quantity"] ?? "";
 $category = trim($_POST["category"] ?? "");
 
 if ( $product_name === "" ||
    $description === "" ||
    $price === "" ||
    $quantity === "" ||
    $category === ""){
    $message = "All fields are required";
 }

 elseif(!is_numeric($price)){
    $message = "Price should be a number";
 }

 elseif(!is_numeric($quantity)){
    $message = "Quantity should be a number";
 }

 elseif($price <0){
    $message= "Price cannot be less than 0";
 }

  elseif($quantity <0){
    $message= "Quantity cannot be less than 0";
 }

  if ($message === ""){
    $sql = "INSERT INTO products (product_name, description, price, quantity, category)
    VALUES (?, ?, ?, ?, ?)";

    $statement = $connection->prepare($sql);

    $statement->execute([
        $product_name,
        $description,
        $price,
        $quantity,
        $category
    ]);

    $message = "Product added successfully";
  }
}

// Get all products
$sql = "SELECT id, product_name, description, price, quantity, create_date, category
        FROM products";

$statement = $connection->query($sql);

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

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
            <h2>Add Product</h2>

            <?php if ($message !== ""): ?>
                <div class="message">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="0" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" required>
                </div>

                <button class="btn" type="submit">Add Product</button>
            </form>
        </section>

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
                            <th>Quantity</th>
                            <th>Created Date</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product["id"]) ?></td>
                                <td><?= htmlspecialchars($product["product_name"]) ?></td>
                                <td><?= htmlspecialchars($product["description"]) ?></td>
                                <td><?= htmlspecialchars($product["price"]) ?></td>
                                <td><?= htmlspecialchars($product["quantity"]) ?></td>
                                <td><?= htmlspecialchars($product["create_date"]) ?></td>
                                <td><?= htmlspecialchars($product["category"]) ?></td>
                                <td class="actions">
                                    <a class="btn btn-small btn-secondary" href="update_product.php?id=<?= $product["id"] ?>">Update</a>
                                    <a class="btn btn-small btn-danger" href="delete_product.php?id=<?= $product["id"] ?>">Delete</a>
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
