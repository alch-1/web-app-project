<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../../include/ConnectionManager.php';
include_once '../../objects/BandMember.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$bandMember = new BandMember($db);
$bandMember->bandName = isset($_GET['bandName']) ? $_GET['bandName'] : die();

// query products
$stmt = $bandMember->searchBandMembers();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if ($num > 0) {

    // products array
    $result_arr = array();
    $result_arr["bandMembers"] = array();
  
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

        $item = $row;

        array_push($result_arr["bandMembers"], $item);
    }
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($result_arr);
}
else {
    // set response code - 404 Not found
    http_response_code(200);
  
    // tell the user item does not exist
    echo json_encode(array("message" => "No band members found"));
}
?>