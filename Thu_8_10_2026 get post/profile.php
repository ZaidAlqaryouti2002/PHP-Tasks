<?php
session_start();

// Check if user session data exists, if not redirect to the registration page
if (!isset($_SESSION['userData'])) {
    header("Location: register.php");
    exit();
}

// Get the user data object from the session
$user = $_SESSION['userData'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            max-width: 500px;
            margin: 40px auto;
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .profile-item {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .label {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2 style="text-align: center; color: green;">Registration Successful!</h2>
    <hr style="margin-bottom: 20px;">

    <div class="profile-item">
        <span class="label">Full Name:</span> 
        <?php echo htmlspecialchars($user->name); ?>
    </div>

    <div class="profile-item">
        <span class="label">Email:</span> 
        <?php echo htmlspecialchars($user->email); ?>
    </div>

    <div class="profile-item">
        <span class="label">Mobile:</span> 
        <?php echo htmlspecialchars($user->mobile); ?>
    </div>

    <div class="profile-item">
        <span class="label">Governorate:</span> 
        <?php echo htmlspecialchars($user->governorate); ?>
    </div>

    <div class="profile-item">
        <span class="label">Track:</span> 
        <?php echo htmlspecialchars($user->track); ?>
    </div>

    <div class="profile-item">
        <span class="label">Skills:</span> 
        <?php 
            // Skills is an array, so we use implode to display them separated by commas
            echo htmlspecialchars(implode(', ', $user->skills)); 
        ?>
    </div>

    <div class="profile-item">
        <span class="label">Message:</span> 
        <p style="margin-top: 5px;"><?php echo nl2br(htmlspecialchars($user->message)); ?></p>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="register.php" style="text-decoration: none; background: #007bff; color: white; padding: 10px 15px; border-radius: 5px;">Back to Registration</a>
    </div>
</div>

</body>
</html>