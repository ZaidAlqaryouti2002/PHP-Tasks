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

      <h1 class="page-title">Dashboard</h1>

      <section class="stats">
        <article class="stat-card">
          <h3>Total Users</h3>
          <strong>0</strong>
        </article>

        <article class="stat-card">
          <h3>Total Products</h3>
          <strong>0</strong>
        </article>
      </section>

      <section class="section">
        <div class="section-header">
          <h2>User Management</h2>
          <a class="btn" href="users.php">Manage Users</a>
        </div>

        <p>View, add, edit, and delete registered users.</p>
      </section>

      <section class="section">
        <div class="section-header">
          <h2>Product Management</h2>
          <a class="btn" href="products.php">Manage Products</a>
        </div>

        <p>View, add, edit, and delete products.</p>
      </section>

    </div>
  </main>

</body>
</html>
