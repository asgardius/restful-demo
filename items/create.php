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
 
$items = new Users($db);
 
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) && !empty($data->firstname) &&
!empty($data->lastname) && !empty($data->email) &&
!empty($data->password) && !empty($data->country) &&
!empty($data->birthdate)){    

    $items->id = $data->id;
    $items->firstname = $data->firstname;
    $items->lastname = $data->lastname;
    $items->email = $data->email;	
    $items->password = $data->password;
    $items->country = $data->country;
    $items->birthdate = $data->birthdate;
    
    if($items->create()){         
        http_response_code(201);         
        echo json_encode(array("message" => "Item was created."));
    } else{         
        http_response_code(503);        
        echo json_encode(array("message" => "Unable to create item."));
    }
}else{    
    http_response_code(400);    
    echo json_encode(array("message" => "Unable to create item. Data is incomplete."));
}
?>