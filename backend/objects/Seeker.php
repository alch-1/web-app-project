<?php
    class Seeker {
    
        // database connection and table name
        private $conn;
        private $table_name = "seekers";

        // object properties
        public $username;
        public $website;
        public $description;
            
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // get all seekers
        public function getAllSeekers() {
        
            // select all query
            $query = "SELECT
                            *
                        FROM
                            seekers";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt;
        }

        // add seeker object into DB
        public function createSeeker() {
            $query = "INSERT INTO
                            seekers (`username`, `website`, `description`) 
                        VALUES
                            (
                                :username,
                                :website,
                                :description
                            )
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":website", $this->website);
            $stmt->bindParam(":description", $this->description);

            // execute query
            $result = $stmt->execute();
        
            return $result;
        }
    }
