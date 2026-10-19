<?php

class Dashboard {
 private $connection;

  public function __construct($connection){
    $this->connection = $connection;
  }

  public function countUsers(){
    $sql = "SELECT COUNT(*) FROM users";

    $statement = $this->connection->query($sql);

    return $statement->fetchColumn();
  }
 
  public function countProducts(){
    $sql = "SELECT COUNT(*) FROM products";

    $statement = $this->connection->query($sql);
    
    return $statement->fetchColumn();
 }

 public function getUsers(){
    $sql = "SELECT id, name, email FROM users";

    $statement = $this->connection->query($sql);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
 }

 public function getProducts(){
    $sql = "SELECT id, product_name, description, price, create_date, category FROM products";

    $statement = $this->connection->query($sql);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
 }




}

?>