<?php
 
//creating response array
$response = array(
    "error" => "",
    "message" => "",
    "points" => ""
    );


    //including the db operation file
    require_once "get_points.php";
    require_once "get_events.php";
    $db = new UserPoints();
 

    //$_SERVER['REQUEST_METHOD']==='POST'
    if(true){
     
        //getting values
        //$user_id = (int)$_POST["user_id"];
        $user_id = 11;

        //inserting values 
        $points = $db->getUserPoints($user_id);
        if($points !== false){
            $response["error"]="false";
            $response["message"]= "Retrieved points";
            $response["points"] = $points;
        }else{
     
            $response["error"]="true";
            $response["message"]='Could not retrieve points';
            $response["points"] = "";
        }

     
    }else{
        $response["error"]="true";
        $response["message"]="You are not authorized";
        $response["points"] = "";
    }
echo json_encode($response);
?>