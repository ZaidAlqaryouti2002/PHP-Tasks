<?php

// =========================
// DATABASE CONNECTION
// =========================
$connection = new mysqli(
    "localhost",
    "root",
    "",
    "register_task",
    3307
);

if ($connection->connect_error) {
    die("Connection Failed: " . $connection->connect_error);
}

?>
