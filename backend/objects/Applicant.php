<?php
    class Applicant {
    
        // database connection and table name
        private $conn;
        private $table_name = "applicants";

        // object properties
        public $gigId;
        public $username;
            
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // get all applicants
        public function getAllApplicants() {
        
            // select all query
            $query = "SELECT
                            *
                        FROM
                            applicants";

        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }


        //get applicants by gigId
        public function getApplicantsByGig() {
        
            // query to read single record
            $query = "SELECT
                            *
                        FROM
                            applicants
                        WHERE
                            gigId = ?";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->gigId);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        //get applicants data by gigId
        public function getApplicantsDataByGig() {
        
            // query to read single record
            $query = "SELECT
                            g.gigId,
                            g.title,
                            g.confirmedApplicant,
                            b.bandName,
                            b.genre,
                            b.bandType,
                            b.username,
                            b.username as username2
                        FROM 
                            gigs g left join applicants a on g.gigId = a.gigId left join bands b on b.username = a.username 
                        WHERE
                            a.gigId = ?";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->gigId);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        //use to check what gigs applicant has alr applied for
        public function getApplicantsByUsername() {
        
            // query to read single record
            $query = "SELECT
                            *
                        FROM
                            applicants
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

        //create applicant
        public function createApplicant() {
            $query = "INSERT INTO
                            applicants (`gigId`, `username`) 
                        VALUES
                            (
                                :gigId,
                                :username
                            )
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(":gigId", $this->gigId);
            $stmt->bindParam(":username", $this->username);

            // execute query
            $result = $stmt->execute();
        
            return $result;
        }
    }
?>