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
    header("Location: products.php");
    exit;
}

// Get product
$sql = "SELECT id, product_name, description, price, quantity, category
        FROM products
        WHERE id = ?";

$statement = $connection->prepare($sql);
$statement->execute([$id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: products.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_name = trim($_POST["product_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = $_POST["price"] ?? "";
    $quantity = $_POST["quantity"] ?? "";
    $category = trim($_POST["category"] ?? "");

    // Validation
    if ($product_name === "" || $description === "" || $price === "" || $quantity === "" || $category === "") {
        $message = "All fields are required";
    } elseif (!is_numeric($price)) {
        $message = "Price should be a number";
    } elseif (!is_numeric($quantity)) {
        $message = "Quantity should be a number";
    } elseif ($price < 0) {
        $message = "Price cannot be less than 0";
    } elseif ($quantity < 0) {
        $message = "Quantity cannot be less than 0";
    }

    // Update product
    if ($message === "") {
        $sql = "UPDATE products
                SET product_name = ?, description = ?, price = ?, quantity = ?, category = ?
                WHERE id = ?";

        $statement = $connection->prepare($sql);
        $statement->execute([
            $product_name,
            $description,
            $price,
            $quantity,
            $category,
            $id
        ]);

        header("Location: products.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="dashboard-main">
    <div class="container">
        <section class="dashboard-section">
            <h2>Update Product</h2>

            <?php if ($message !== ""): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product["product_name"]) ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?= htmlspecialchars($product["description"]) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($product["price"]) ?>" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="0" value="<?= htmlspecialchars($product["quantity"]) ?>" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" value="<?= htmlspecialchars($product["category"]) ?>" required>
                </div>

                <button class="btn" type="submit">Update Product</button>
                <a class="btn btn-secondary" href="products.php">Cancel</a>
            </form>
        </section>
    </div>
</main>

</body>
</html>
