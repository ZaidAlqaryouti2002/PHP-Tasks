<?php
session_start();

require "db.php";

if (!isset($_SESSION["user_id"])){
  header("Location: login.php");
  exit;
}

$result = $con->query(
   "SELECT id, name, email FROM users"
);
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
      <h1 class="page-title">Users</h1>

      <section class="section">
        <div class="two-columns">

          <div>
            <h2>Add / Edit User</h2>

            <form action="" method="post">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
              </div>

              <button class="btn" type="submit">Save User</button>
            </form>
          </div>

          <div>
            <h2>Registered Users</h2>

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
               <h1>
               Welcome,
              <?= htmlspecialchars($_SESSION["user_name"]) ?>
               </h1>
                <tbody>
                 <?php while ($user = $result->fetch_assoc()): ?>

                <tr>
                 <td><?= $user["id"] ?></td>
                 <td><?= htmlspecialchars($user["name"]) ?></td>
                 <td><?= htmlspecialchars($user["email"]) ?></td>
                </tr>

                <?php endwhile; ?>
                  <tr>
                    <td>1</td>
                    <td>Example User</td>
                    <td>example@email.com</td>
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
