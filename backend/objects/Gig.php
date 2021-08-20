<?php
    class Gig {
    
        // database connection and table name
        private $conn;
        private $table_name = "gigs";

        // object properties
        public $gigId;
        public $username;
        public $title;
        public $location;
        public $postalCode;
        public $genre;
        public $songs;
        public $budget;
        public $duration;
        public $date;
        public $noMusicians;
        public $description;
        public $image;
        public $status;
        public $confirmedApplicant;
            
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // get all gigs
        public function getAllGigs() {
        
            // select all query
            $query = "SELECT
                            *
                        FROM
                            gigs";

        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        //get gig by gigId
        public function getGig() {
        
            // query to read single record
            $query = "SELECT
                            *
                        FROM
                            gigs
                        WHERE
                            gigId = ?
                        LIMIT
                            0,1";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->gigId);
        
            // execute query
            $stmt->execute();
        
            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // set values to object properties
            $this->username = $row['username'];
            $this->title = $row['title'];
            $this->location = $row['location'];
            $this->postalCode = $row['postalCode'];
            $this->genre = $row['genre'];
            $this->songs = $row['songs'];
            $this->budget = $row['budget'];
            $this->duration = $row['duration'];
            $this->date = $row['date'];
            $this->noMusicians = $row['noMusicians'];
            $this->description = $row['description'];
            $this->image = $row['image'];
            $this->status = $row['status'];
            $this->confirmedApplicant = $row['confirmedApplicant'];
        }

        //get gig by userID
        public function getGigByUser() {
        
            // query to read single record
            $query = "SELECT
                            g.*,
                             a.counts,
                              g.gigId as gigId2  
                        FROM
                             gigs g left join (select gigid, count(gigid) as counts from applicants group by gigid) as a on g.gigid = a.gigid
                        WHERE
                            username = ?
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->username);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        //get gig by applicant userID
        public function getGigByApplicant() {
        
            // query to read single record
            $query = "SELECT
                            g.gigId,
                            title,
                            location,
                            postalCode,
                            genre,
                            songs,
                            budget,
                            duration,
                            date,
                            description,
                            status,
                            confirmedApplicant
                        FROM 
                            gigs g left join applicants a on g.gigId = a.gigId
                        WHERE
                            a.username = ?
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->username);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        // add gig object into DB
        public function createGig() {
            $query = "INSERT INTO
                            gigs (`username`, `title`, `location`,`postalCode`, `genre`, `songs`, `budget`, `duration`, `date`, `noMusicians`, `description`, `image`, `status`, `confirmedApplicant`) 
                        VALUES
                            (
                                :username,
                                :title,
                                :location,
                                :postalCode,
                                :genre,
                                :songs,
                                :budget,
                                :duration,
                                :date,
                                :noMusicians,
                                :description,
                                :image,
                                :status,
                                :confirmedApplicant
                            )
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":location", $this->location);
            $stmt->bindParam(":postalCode", $this->postalCode);
            $stmt->bindParam(":genre", $this->genre);
            $stmt->bindParam(":songs", $this->songs);
            $stmt->bindParam(":budget", $this->budget);
            $stmt->bindParam(":duration", $this->duration);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":noMusicians", $this->noMusicians);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":image", $this->image);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":confirmedApplicant", $this->confirmedApplicant);

            // execute query
            $result = $stmt->execute();
        
            return $result;
        }

        //use to search db for title wildcard
        public function searchGigByTitle() {
            // query 
            $query = "SELECT
                            *
                        FROM
                            gigs
                        WHERE
                            title like CONCAT('%',?,'%')
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->title);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        //use to confirm a username as the confirmedApplicant
        public function confirmGigApplicant() {
            $query = "UPDATE gigs
                        SET
                            confirmedApplicant=:confirmedApplicant
                        WHERE
                            gigId=:gigId
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(":gigId", $this->gigId);
            $stmt->bindParam(":confirmedApplicant", $this->confirmedApplicant);

            // execute query
            $result = $stmt->execute();
        
            return $result;
        }

        //use to cancel the confirmedApplicant
        public function cancelGigApplicant() {
            $query = "UPDATE gigs
                        SET
                            confirmedApplicant=null
                            WHERE
                            gigId=:gigId
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(":gigId", $this->gigId);

            // execute query
            $result = $stmt->execute();
        
            return $result;
        }


        //use to delete a gig using ID
        public function deleteGig() {
            $query = "DELETE FROM gigs
                        WHERE
                            gigId=:gigId
                        ";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(":gigId", $this->gigId);

            // execute query
            $result = $stmt->execute();
        
            return $result;
        }
        
    }
?>