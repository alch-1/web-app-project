<?php
    class User {
    
        // database connection and table name
        private $conn;
        private $table_name = "users";

        // object properties
        public $userId;
        public $username;
        public $name;
        public $type;
            
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // get all users
        public function getAllUsers() {
        
            // select all query
            $query = "SELECT
                            *
                        FROM
                            users";

        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }


        //get users by username
        public function getUserByUsername() {
        
            // query to read single record
            $query = "SELECT
                            *
                        FROM
                            users
                        WHERE
                            username = ?";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->username);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        //get users by type
        public function getUserByType() {
        
            // query to read single record
            $query = "SELECT
                            *
                        FROM
                            users
                        WHERE
                            type = ?";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->type);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        // add user object into DB
        public function createUser() {
            $query = "INSERT INTO
                            users (`username`, `name`, `type`) 
                        VALUES
                            (
                                :username,
                                :name,
                                :type
                            )
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":type", $this->type);

            // execute query
            $result = $stmt->execute();
        
            return $result;
        }

    }
?>