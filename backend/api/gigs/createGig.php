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
include_once '../../objects/Gig.php';
  
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$gig = new Gig($db);

// set property of record to read

//MANDATORY
$gig->username = isset($_POST['username']) ? $_POST['username'] : die();
$gig->title = isset($_POST['title']) ? $_POST['title'] : die();
$gig->location = isset($_POST['location']) ? $_POST['location'] : die();
$gig->postalCode = isset($_POST['postalCode']) ? $_POST['postalCode'] : die();
$gig->date = isset($_POST['date']) ? $_POST['date'] : die();

//OPTIONAL
$gig->genre = isset($_POST['genre']) ? $_POST['genre'] : null;
$gig->songs = isset($_POST['songs']) ? $_POST['songs'] : null;
$gig->budget = isset($_POST['budget']) ? $_POST['budget'] : null;
$gig->duration = isset($_POST['duration']) ? $_POST['duration'] : null;
$gig->noMusicians = isset($_POST['noMusicians']) ? $_POST['noMusicians'] : null;
$gig->description = isset($_POST['description']) ? $_POST['description'] : null;
$gig->status = isset($_POST['status']) ? $_POST['status'] : "pending";
$gig->confirmedApplicant = isset($_POST['confirmedApplicant']) ? $_POST['confirmedApplicant'] : null ;

// For image handling
if(isset($_FILES['image'])) {
    $target_file = basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");

    if( in_array($imageFileType,$extensions_arr) ){
        $image_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']) );
        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
        $gig->image = $image;
    }else {
        $gig->image = null;
    }
} else {
    $gig->image = null;
}
  
// read the details of product to be edited
$result = $gig->createGig();
  
if($result) {

    // create array
    $item = array(
        "message" => "gig created",
        "result" => $result
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