<?php
class BandMember
{
  // database connection and table name
  private $conn;
  private $table_name = "bandMembers";

  // object properties
  public $bandName;
  public $name;
  public $image;
  public $role;

  // constructor with $db as database connection
  public function __construct($db){
    $this->conn = $db;
  }

  public function decode($param) {
    return urldecode($param); 
  }

  // get all band members
  public function getAllBandMembers(){
    // select all query
    $query = "SELECT
                *
              FROM
                bandMembers";
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }


    // search band member
    public function searchBandMembers(){
      $query = "SELECT
                  *
                FROM
                  bandMembers
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



  // add bandMember object into DB
  public function createBandMember() {
    $query = "INSERT INTO
                    bandMembers (`bandName`, `name`, `image`, `role`) 
                VALUES
                    (
                        :bandName,
                        :name,
                        :image,
                        :role
                    )
                ";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(":bandName", $this->bandName);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":image", $this->image);
    $stmt->bindParam(":role", $this->role);

    // execute query
    $result = $stmt->execute();

    return $result;
  }
}
?>