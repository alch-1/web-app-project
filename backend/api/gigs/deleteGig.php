<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../../include/ConnectionManager.php';
include_once '../../objects/Gig.php';
  
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$gig = new Gig($db);

// set property of record to read
//MANDATORY
$gig->gigId = isset($_POST['gigId']) ? $_POST['gigId'] : die() ;


// read the details of product to be edited
$result = $gig->deleteGig();
  
if($result) {

    // create array
    $item = array(
        "message" => "gig deleted"
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($item);
}
else {
    // set response code - 400 BAD REQUEST
    http_response_code(400);
  
    echo json_encode(array("message" => "failed"));
}
?>