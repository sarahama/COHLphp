<?php
 
 //creating response array
    $response = array(
        "error" => "",
        "message" => "",
        "rewards" => "" 
    );
    //including the db operation file
    require_once "get_store.php";
    $db = new GetStore();


    if($_SERVER['REQUEST_METHOD']==='POST'){
     
        $rewards = false;
        //getting values
        $action = $_POST["action"];


        if ($action === "view_all") {
            
            $rewards = $db->getAllRewards();
            
            if($rewards !== false){
                $response["error"]="false";
                $response["message"]='Store retrieved';
                $response["rewards"] = $rewards;
            } else { 
                $response["error"]="true";
                $response["message"]='Could not access the store';
                $response["rewards"] = "";
            }

        } elseif($action === "view_user_rewards"){
            // get the current users rewards
            $user_id = $_POST["user_id"];
            $rewards = $db->getUserRewards($user_id);
            
            if($rewards !== false && $rewards !== []){
                $response["error"]="false";
                $response["message"]='Rewards retrieved';
                $response["rewards"] = $rewards;
            } else { 
                $response["error"]="true";
                $response["message"]='Could not access the rewards, user may not have any';
                $response["rewards"] = "";
            }

        } elseif ($action === "purchase") {
            $user_id = $_POST["user_id"];
            $reward_id = $_POST["reward_id"];
            $purchase = $db->purchaseReward($user_id, $reward_id);
            if($purchase !== false) {
                $response["error"]="false";
                $response["message"]= "Successfully purchased reward!";
                $response["rewards"] = "";
            } else{
                $response["error"]="true";
                $response["message"]="Could not make purchase";
                $response["rewards"] = "";
            }
        } 
     
    }else{
        $response["error"]="true";
        $response["message"]="You are not authorized";
        $response["rewards"] = "";
    }
echo json_encode($response);
        

?>
