<?php

require "db.php";
$error = "";
$success= "";

if($_SERVER["REQUEST_METHOD"] === "POST"){

  $name= trim($_POST["name"] ?? "");
  $email = trim($_POST["email"] ?? "");
  $password = $_POST["password"] ?? "";

  if($name === "" || $email === "" || $password === ""){
    $error = "All fields are required";
  } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = "Please enter a valid email";
  }
  
  if($error === ""){
    $statement= $con->prepare("SELECT id FROM users WHERE email = ?");
    $statement->bind_param("s",$email);
    $statement->execute();

    $result = $statement->get_result();

    if ($result->num_rows >0){
      $error= "Email is already exists";
    }

    if($error === ""){
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

     $statement = $con->prepare(
        "INSERT INTO users (name, email, password)
         VALUES (?, ?, ?)"
     );

     $statement->bind_param("sss", $name, $email, $hashedPassword);

     if ($statement->execute()){
      $success = "Registrarion successful";
     } else {
      $error = "Registration failed";
     }

    }
   
  }
 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <main class="auth-page">
    <section class="auth-card">
      <h1>Create Account</h1>
      <p>Register a new user account.</p>

      <?php if ($error !== ""): ?>
        <p class = "message message-error">
          <?= htmlspecialchars($error) ?>
        </p>
      <?php endif; ?>

      <?php if ($success !== ""): ?>
         <p class="message message-success">
         <?= htmlspecialchars($success) ?>
         </p>
      <?php endif; ?>

      <form action="" method="post">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group" >
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <button class="btn" type="submit">Register</button>
      </form>

      <div class="auth-link">
        Already have an account? <a href="login.php">Login</a>
      </div>
    </section>
  </main>

</body>
</html>
