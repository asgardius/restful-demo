<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/Database.php';
include_once '../class/Users.php';
 
$database = new Database();
$db = $database->getConnection();

$islogincorrect = false;
 
$items = new Users($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) &&
!empty($data->password)){
    $items->id = $data->id;
    $items->password = $data->password;
}

//$items->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$result = $items->rcheck();

if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["items"]=array();
    while ($item = $result->fetch_assoc()) {
        extract($item);
        $itemDetails=array(
            "id" => $id,
            "password" => $password
        ); 
        if($data->id == $id && $data->password == $password) {
            $islogincorrect = true;
        }
       array_push($itemRecords["items"], $itemDetails);
    }    
    http_response_code(200);     
    //echo json_encode($itemRecords);
}

if(!empty($data->id) &&
!empty($data->password) && $islogincorrect){    
    http_response_code(201);         
    echo json_encode(array("message" => "Password is correct."));
}else{    
    http_response_code(403);    
    echo json_encode(array("message" => "Invalid credentials."));
}
?>