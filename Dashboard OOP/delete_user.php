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
    $sql = "DELETE FROM users WHERE id = ?";

    $statement = $connection->prepare($sql);
    $statement->execute([$id]);
}

if ($_SESSION["user_id"] == $id) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

header("Location: users.php");
exit;

?>
