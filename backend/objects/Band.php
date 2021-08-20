<?php
class Band
{
  // database connection and table name
  private $conn;
  private $table_name = "bands";

  // object properties
  public $username;
  public $bandName;
  public $genre;
  public $bandType;
  public $website;
  public $summary;
  public $image;

  // constructor with $db as database connection
  public function __construct($db){
    $this->conn = $db;
  }

  public function decode($param) {
    return urldecode($param); 
  }

  // get all bands
  public function getAllBands(){
    // select all query
    $query = "SELECT
                *
              FROM
                bands";
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }

  // get bands by bandName
  public function getBandsByName(){
    // select all query
    $query = "SELECT
                *
              FROM
                bands
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

  // add band object into DB
  public function createBand() {
    $query = "INSERT INTO
                    bands (`username`, `bandName`, `genre`, `bandType`,`website`, `summary`, `image`) 
                VALUES
                    (
                        :username,
                        :bandName,
                        :genre,
                        :bandType,
                        :website,
                        :summary,
                        :image
                    )
                ";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":bandName", $this->bandName);
    $stmt->bindParam(":genre", $this->genre);
    $stmt->bindParam(":bandType", $this->bandType);
    $stmt->bindParam(":website", $this->website);
    $stmt->bindParam(":summary", $this->summary);
    $stmt->bindParam(":image", $this->image);

    // execute query
    $result = $stmt->execute();

    return $result;
  }

  // get bands by username
  public function getBandsByUsername(){
    // select all query
    $query = "SELECT
                *
              FROM
                bands
              WHERE
                username = ?";
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind bandName
    $username = $this->decode($this->username);
    $stmt->bindParam(1, $username);

    // execute query
    $stmt->execute();

    return $stmt;
  }

  // search bands by bandName
  public function searchBandsByName(){
    // select all query
    $query = "SELECT
                *
              FROM
                bands
              WHERE
                bandName like CONCAT('%',?,'%')";
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind bandName
    $bandName = $this->decode($this->bandName);
    $stmt->bindParam(1, $bandName);

    // execute query
    $stmt->execute();

    return $stmt;
  }
}
?>