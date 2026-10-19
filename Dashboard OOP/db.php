<?php

try {

    $host = "localhost";
    $database = "register_task";
    $username = "root";
    $password = "";
    $port = "3307";

    $connection = new PDO(
        "mysql:host=$host;port=$port;dbname=$database",
        $username,
        $password
    );

} catch (PDOException $error) {

    echo "Connection failed: " . $error->getMessage();
    die();
}

?>