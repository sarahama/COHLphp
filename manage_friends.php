<?php
 
 //creating response array
	$response = array(
    "error" => "",
    "message" => "",
    "user" => "" 
    );
    //including the db operation file
    require_once "get_friends.php";
    $db = new GetFriends();

 
    if($_SERVER['REQUEST_METHOD']==='POST'){
        
     	$friends = false;
        //getting values
        $select_type = $_POST["select_type"];
        $user_id = $_POST["user_id"];


        if ($select_type === "view_friends") {
        	$friends = $db->getConnectedFriends($user_id);
        

        } elseif ($select_type === "view_unconnected_friends") {
        	$phone_list = $_POST["phone_list"];
        	$friends = $db->getUnconnectedFriends($user_id, $phone_list);

        
        } elseif ($select_type === "request_friend") {
        	$friend_id = $_POST["friend_id"];
        	$friends = $db->sendFriendRequest($user_id, $friend_id);


        } elseif ($select_type === "request_response") {
        	$friend_id = $_POST["friend_id"];
            $accept = $_POST["accept"];
        	$friends = $db->respondToRequest($user_id, $friend_id, $accept);

        }


       
        if($friends !== false){

            $response["error"]="false";
            $response["message"]='Friends retrieved';
            $response["user"] = $friends;
        }else{
            $response["error"]="true";
            $response["message"]='Could not access friends';
            $response["user"] = "";
        }
     
    }else{
        $response["error"]="true";
        $response["message"]="You are not authorized";
        $response["user"] = "";
    }
echo json_encode($response);
        

?>
