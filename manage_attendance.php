<?php
 
//creating response array
$response = array(
    "error" => "",
    "message" => ""
    );


    //including the db operation file
    require_once "check_in.php";
    $db = new CheckIn();
 

    //$_SERVER['REQUEST_METHOD']==='POST'
    if($_SERVER['REQUEST_METHOD']==='POST'){
     
        //getting values
        $user_id = (int)$_POST["user_id"];
        
        $event_id = (int)$_POST["event_id"];

        $code = $_POST["code"];

      
        //inserting values 
        if($db->checkIntoEvent($user_id, $event_id, $code)){
            $response["error"]="false";
            $response["message"]='Checked in successfully';
        }else{
     
            $response["error"]="true";
            $response["message"]='Could not checkin or add points';
        }
     
    }else{
        $response["error"]="true";
        $response["message"]="You are not authorized";
    }
echo json_encode($response);
?>