<?php
    class PastExperience {
    
        // database connection and table name
        private $conn;
        private $table_name = "pastExperience";

        // object properties
        public $bandName;
        public $date;
        public $location;
        public $postalCode;
        public $image;
        public $description;
            
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        public function decode($param) {
            return urldecode($param); 
          }

        // get all past experience
        public function getAllPastExperience() {
        
            // select all query
            $query = "SELECT
                            *
                        FROM
                            pastExperience";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt;
        }

        // search past experience
        public function searchPastExperience() {
        
            // select all query
            $query = "SELECT
                            *
                        FROM
                            pastExperience
                        WHERE
                            bandName = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind bandName
            $bandName = $this->decode($this->bandName);
            $stmt->bindParam(1, $bandName);

            // execute query
            $stmt->execute();

            return $stmt;
        }
        
        // add past experience object into DB
        public function createPastExperience() {
            $query = "INSERT INTO
                            pastExperience (`bandName`, `date`, `location`, `postalCode`, `image`, `description`) 
                        VALUES
                            (
                                :bandName,
                                :date,
                                :location,
                                :postalCode,
                                :image,
                                :description
                            )
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(":bandName", $this->bandName);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":location", $this->location);
            $stmt->bindParam(":postalCode", $this->postalCode);
            $stmt->bindParam(":image", $this->image);
            $stmt->bindParam(":description", $this->description);

            // execute query
            $result = $stmt->execute();
        
            return $result;
        }
    }
?>