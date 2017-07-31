<?php
 
 //creating response array
	$response = array(
    "error" => "",
    "message" => "",
    "rewards" => "" 
    );
    //including the db operation file
    require_once "get_rewards.php";
    $db = new GetRewards();
 

    // $_SERVER['REQUEST_METHOD']==='POST'
    if($_SERVER['REQUEST_METHOD']==='POST'){
     
     	$rewards = false;
        //getting values

        $user_id = $_POST["user_id"];
        $rewards = $db->getUserRewards($user_id);
        $select_type = $_POST["select_type"];


       
        if($rewards !== false){

            $response["error"]="false";
            $response["message"]='Rewards retrieved';
            $response["rewards"] = $rewards;
        }else{
            $response["error"]="true";
            $response["message"]='Could not get users rewards';
            $response["rewards"] = "";
        }
     
    }else{
        $response["error"]="true";
        $response["message"]="You are not authorized";
        $response["rewards"] = "";
    }
echo json_encode($response);
        

?>
