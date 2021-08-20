<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../../include/ConnectionManager.php';
include_once '../../objects/User.php';
  
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new User($db);

// set property of record to read

//MANDATORY
$user->username = isset($_POST['username']) ? $_POST['username'] : die();
$user->name = isset($_POST['name']) ? $_POST['name'] : die();
$user->type = isset($_POST['type']) ? $_POST['type'] : die();
  
// read the details of product to be edited
$result = $user->createUser();
  
if($result) {

    // create array
    $item = array(
        "message" => "user created"
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