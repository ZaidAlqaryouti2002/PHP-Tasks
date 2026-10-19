<?php
session_start();

require_once "db.php";

//protect page
if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}

$id = $_GET["id"] ?? "";

if ($id !== "") {
    $sql = "DELETE FROM products WHERE id = ?";

    $statement = $connection->prepare($sql);
    $statement->execute([$id]);
}

header("Location: products.php");
exit;

?>
