<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header('Content-Type: multipart/form-data');

// include database and object files
include_once '../../include/ConnectionManager.php';
include_once '../../objects/Band.php';
  
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$band = new Band($db);

// set property of record to read

//MANDATORY
$band->username = isset($_POST['username']) ? $_POST['username'] : "";
$band->bandName = isset($_POST['bandName']) ? $_POST['bandName'] : "";
$band->genre = isset($_POST['genre']) ? $_POST['genre'] : "";
$band->summary = isset($_POST['summary']) ? $_POST['summary'] : "";

//OPTINOAL
$band->website = isset($_POST['website']) ? $_POST['website'] : "";
$band->bandType = isset($_POST['bandType']) ? $_POST['bandType'] : "solo";


// For image handling
if(isset($_FILES['image'])) {
    $target_file = basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");

    if( in_array($imageFileType,$extensions_arr) ){
        $image_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']) );
        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
        $band->image = $image;
    }else {
        $band->image = null;
    }
} else {
    $band->image = null;
}
// read the details of product to be edited
$result = $band->createBand();
  
if($result) {

    // create array
    $item = array(
        "message" => "band created"
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