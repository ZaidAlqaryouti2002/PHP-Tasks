<?php
session_start();

//setting empty variables for the values and error codes to prevent code errors
$name = '';

// Check if user name is stored in Cookie
if (isset($_COOKIE['saved_name'])) {
    $name = $_COOKIE['saved_name'];
}

$email = '';
$mobile = '';
$governorate = '';
$track = '';
$skills = [];
$message = '';
$agree = false;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Collect and clean text inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $governorate = trim($_POST['governorate'] ?? '');
    $track = trim($_POST['track'] ?? '');
    $skills = $_POST['skills'] ?? []; // Checkboxes come as an array
    $message = trim($_POST['message'] ?? '');
    $agree = isset($_POST['agree']);   // True if checked false if not

    // Validation for Full Name
    if (empty($name)) {
        $errors['name'] = 'Full Name is required';
    }

    // Validation for Email
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    // Validation for Mobile number
    if (empty($mobile)) {
        $errors['mobile'] = 'Mobile number is required';
    } elseif (!preg_match('/^07[789]\d{7}$/', $mobile)) {
        $errors['mobile'] = 'Invalid mobile number';
    }

    // Validation for Governate
    if (empty($governorate)) {
        $errors['governorate'] = 'Please select a governorate';
    }

    // Validation for Track
    if (empty($track)) {
        $errors['track'] = 'Please choose a track';
    }

    // Validation for Skills
    if (empty($skills)) {
        $errors['skills'] = 'Please select at least one skill';
    }

    // Validation for Terms
    if (!$agree) {
        $errors['agree'] = 'You must agree to the terms';
    }

    // If everything is valid, process the registration
    if (empty($errors)) {
        // Save Data in an Object
        $userData = new stdClass();
        $userData->name = $name;
        $userData->email = $email;
        $userData->mobile = $mobile;
        $userData->governorate = $governorate;
        $userData->track = $track;
        $userData->skills = $skills;
        $userData->message = $message;

        // Save in Session
        $_SESSION['userData'] = $userData;

        // Save in Cookie
        setcookie('saved_name', $name, time() + (86400 * 30), "/");

        // Redirect to profile page
        header("Location: profile.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error {
            color: red;
            font-size: 13px;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<form action="" method="post">

    <!-- 1. Full Name -->
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <?php if (isset($errors['name'])): ?>
        <span class="error"><?php echo $errors['name']; ?></span>
    <?php endif; ?>

    <!-- 2. Email -->
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <?php if (isset($errors['email'])): ?>
        <span class="error"><?php echo $errors['email']; ?></span>
    <?php endif; ?>

    <!-- 3. Mobile -->
    <label for="mobile">Mobile</label>
    <input type="tel" id="mobile" name="mobile" placeholder="0791234567" value="<?php echo htmlspecialchars($mobile); ?>">
    <?php if (isset($errors['mobile'])): ?>
        <span class="error"><?php echo $errors['mobile']; ?></span>
    <?php endif; ?>

    <!-- 4. Governorate -->
    <label for="governorate">Governorate</label>
    <select id="governorate" name="governorate">
        <option value="">Choose a governorate</option>
        <option value="Amman" <?php echo ($governorate === 'Amman') ? 'selected' : ''; ?>>Amman</option>
        <option value="Irbid" <?php echo ($governorate === 'Irbid') ? 'selected' : ''; ?>>Irbid</option>
        <option value="Aqaba" <?php echo ($governorate === 'Aqaba') ? 'selected' : ''; ?>>Aqaba</option>
        <option value="Zarqa" <?php echo ($governorate === 'Zarqa') ? 'selected' : ''; ?>>Zarqa</option>
    </select>
    <?php if (isset($errors['governorate'])): ?>
        <span class="error"><?php echo $errors['governorate']; ?></span>
    <?php endif; ?>

    <!-- 5. Track -->
    <label>Track</label>
    <label class="inline">
        <input type="radio" name="track" value="Full Stack" <?php echo ($track === 'Full Stack') ? 'checked' : ''; ?>>
        Full Stack
    </label>
    <label class="inline">
        <input type="radio" name="track" value="Frontend" <?php echo ($track === 'Frontend') ? 'checked' : ''; ?>>
        Frontend
    </label>
    <label class="inline">
        <input type="radio" name="track" value="Backend" <?php echo ($track === 'Backend') ? 'checked' : ''; ?>>
        Backend
    </label>
    <?php if (isset($errors['track'])): ?>
        <span class="error"><?php echo $errors['track']; ?></span>
    <?php endif; ?>

    <!-- 6. Skills -->
    <label>Skills you already have</label>
    <label class="inline">
        <input type="checkbox" name="skills[]" value="HTML" <?php echo in_array('HTML', $skills) ? 'checked' : ''; ?>>
        HTML
    </label>
    <label class="inline">
        <input type="checkbox" name="skills[]" value="CSS" <?php echo in_array('CSS', $skills) ? 'checked' : ''; ?>>
        CSS
    </label>
    <label class="inline">
        <input type="checkbox" name="skills[]" value="JavaScript" <?php echo in_array('JavaScript', $skills) ? 'checked' : ''; ?>>
        JavaScript
    </label>
    <?php if (isset($errors['skills'])): ?>
        <span class="error"><?php echo $errors['skills']; ?></span>
    <?php endif; ?>

    <!-- 7. Message -->
    <label for="message">Why do you want to join? (optional)</label>
    <textarea id="message" name="message" rows="4"><?php echo htmlspecialchars($message); ?></textarea>

    <!-- 8. Terms & Conditions -->
    <label class="inline terms">
        <input type="checkbox" name="agree" <?php echo $agree ? 'checked' : ''; ?>>
        I agree to the academy terms
    </label>
    <?php if (isset($errors['agree'])): ?>
        <span class="error"><?php echo $errors['agree']; ?></span>
    <?php endif; ?>

    <button type="submit">Register</button>

</form>

</body>
</html>