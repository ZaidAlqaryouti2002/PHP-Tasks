<?php

// =========================
// 1) START SESSION
// =========================
session_start();

// =========================
// 2) CLEAR SESSION DATA
// =========================
session_unset();

// =========================
// 3) DESTROY SESSION
// =========================
session_destroy();

// =========================
// 4) REDIRECT TO LOGIN
// =========================
header("Location: login.php");
exit;

?>
