<?php

class DB_con {

    private $connection;

    public function __construct() {

        $host = "localhost";
        $database = "oopscrud";
        $username = "root";
        $password = "";
        $port = "3307";

        try {

            $this->connection = new PDO(
                "mysql:host=$host;port=$port;dbname=$database",
                $username,
                $password
            );

        } catch (PDOException $error) {

            echo "Connection failed: " . $error->getMessage();
            die();
        }
    }


    // Create
    public function insert($fname, $lname, $email, $contact, $address) {

        $sql = "INSERT INTO tblusers
                (FirstName, LastName, EmailId, ContactNumber, Address)
                VALUES (?, ?, ?, ?, ?)";

        $statement = $this->connection->prepare($sql);

        return $statement->execute([
            $fname,
            $lname,
            $email,
            $contact,
            $address
        ]);
    }


    // Read all
    public function fetchdata() {

        $sql = "SELECT * FROM tblusers";

        $statement = $this->connection->query($sql);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    // Read one
    public function fetchonerecord($id) {

        $sql = "SELECT * FROM tblusers WHERE id = ?";

        $statement = $this->connection->prepare($sql);

        $statement->execute([$id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    // Update
    public function update($fname, $lname, $email, $contact, $address, $id) {

        $sql = "UPDATE tblusers
                SET FirstName = ?,
                    LastName = ?,
                    EmailId = ?,
                    ContactNumber = ?,
                    Address = ?
                WHERE id = ?";

        $statement = $this->connection->prepare($sql);

        return $statement->execute([
            $fname,
            $lname,
            $email,
            $contact,
            $address,
            $id
        ]);
    }


    // Delete
    public function delete($id) {

        $sql = "DELETE FROM tblusers WHERE id = ?";

        $statement = $this->connection->prepare($sql);

        return $statement->execute([$id]);
    }

}

?>