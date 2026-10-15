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
      <h1 class="page-title">Products</h1>

      <section class="section">
        <div class="two-columns">

          <div>
            <h2>Add / Edit Product</h2>

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

              <button class="btn" type="submit">Save Product</button>
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
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <!-- PHP loop will display products here later -->
                  <tr>
                    <td>1</td>
                    <td>Example Product</td>
                    <td>25.00</td>
                    <td>5</td>
                    <td>2026-10-13</td>
                    <td class="actions">
                      <a class="btn btn-small btn-secondary" href="#">Edit</a>
                      <a class="btn btn-small btn-danger" href="#">Delete</a>
                    </td>
                  </tr>
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
