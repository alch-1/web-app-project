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
include_once '../../objects/PastExperience.php';
  
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$pastExperience = new PastExperience($db);

// set property of record to read

//MANDATORY
$pastExperience->bandName = isset($_POST['bandName']) ? $_POST['bandName'] : die();
$pastExperience->date = isset($_POST['date']) ? $_POST['date'] : die();
$pastExperience->location = isset($_POST['location']) ? $_POST['location'] : die();
$pastExperience->postalCode = isset($_POST['postalCode']) ? $_POST['postalCode'] : die();
$pastExperience->description = isset($_POST['description']) ? $_POST['description'] : die();

//OPTIONAL
// For image handling
if(isset($_FILES['image'])) {
    $target_file = basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");

    if( in_array($imageFileType,$extensions_arr) ){
        $image_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']) );
        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
        $pastExperience->image = $image;
    }else {
        $pastExperience->image = null;
    }
} else {
    $pastExperience->image = null;
}
  
// read the details of product to be edited
$result = $pastExperience->createPastExperience();
  
if($result) {

    // create array
    $item = array(
        "message" => "past experience created"
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