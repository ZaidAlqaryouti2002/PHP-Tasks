<?php
$con = new mysqli("localhost", "root", "", "register_task", 3307);
if($con -> connect_error){
    die("Connection failed: " . $con->connect_error);
}

?>