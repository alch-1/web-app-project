<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
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
  
// set ID property of record to read
$gig->gigId = isset($_GET['gigId']) ? $_GET['gigId'] : die();
  
// read the details of product to be edited
$gig->getGig();
  
if($gig->username != null) {

    // create array
    $item = array(
        "gig" => $gig
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($item);
}
else {
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user item does not exist
    echo json_encode(array("message" => "Unable to find."));
}
?>