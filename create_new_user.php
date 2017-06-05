<?php
 
//creating response array
$response = array(
    "error" => "",
    "message" => "",
    "user_id" => "" 
    );


    //including the db operation file
    require_once "new_user.php";
    $db = new CreateNewUser();
 


    if($_SERVER['REQUEST_METHOD']==='POST'){
     
        //getting values
        $first_name = $_POST["first_name"];
        
        $fb_id = $_POST["fb_id"];
     
        //inserting values 
        $current_user_id = $db->createUser($first_name, $fb_id);
        if($current_user_id !== false){
            $response["error"]="false";
            $response["message"]='User created successfully or user already existed';
            $response["user_id"] = $current_user_id;
        }else{
            $response["error"]="true";
            $response["message"]='Could not create new user';
            $response["user_id"] = "";
        }
     
    }else{
        $response["error"]="true";
        $response["message"]="You are not authorized";
        $response["user_id"] = "";
    }
echo json_encode($response);
?>