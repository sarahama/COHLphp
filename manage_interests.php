<?php
 
//creating response array
$response = array(
    "error" => "",
    "message" => "" 
    );

if($_SERVER['REQUEST_METHOD']==='POST'){
 
    //getting values
    $user_id = $_POST["user_id"];
    
    $event_id = $_POST["event_id"];

    //including the db operation file
    require_once "new_interest.php";
    $db = new CreateNewInterest();
 
    //inserting values 
    if($db->createInterest($user_id, $event_id)){
        $response["error"]="false";
        $response["message"]='Interest created successfully';
    }else{
 
        $response["error"]="true";
        $response["message"]='Could not create new Interest';
    }
 
}else{
    $response["error"]="true";
    $response["message"]="You are not authorized";
}
echo json_encode($response);
?>