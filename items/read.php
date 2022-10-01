<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/Users.php';

$database = new Database();
$db = $database->getConnection();
 
$items = new Users($db);

//$items->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->id)) {
	$items->id = $data->id;
}
$result = $items->read();

if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["items"]=array(); 
	while ($item = $result->fetch_assoc()) { 	
        extract($item);
        $itemDetails=array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
			"email" => $email,
            "password" => $password,            
			"country" => $country,
            "birthdate" => $birthdate,
            "permission" => $permission
        ); 
       array_push($itemRecords["items"], $itemDetails);
    }    
    http_response_code(200);     
    echo json_encode($itemRecords);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No item found.")
    );
} 