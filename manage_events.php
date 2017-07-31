<?php
 
 //creating response array
	$response = array(
    "error" => "",
    "message" => "",
    "events" => "" 
    );
    //including the db operation file
    require_once "get_events.php";
    $db = new GetEvents();
 
 	// $events = $db->getAllUpcomingEvents();
 	// echo json_encode($events);
 
    
    if($_SERVER['REQUEST_METHOD']==='POST'){
     
     	$events = false;
        //getting values
        $select_type = $_POST["select_type"];

        if ($select_type === "all") {
        	
        	$events = $db->getAllUpcomingEvents();
        
        } elseif ($select_type === "interested") {
        	$user_id = $_POST["user_id"];
        	$events = $db->getInterestedEvents($user_id);
        
        } elseif ($select_type === "attended") {
        	$user_id = $_POST["user_id"];
        	$events = $db->getAllAttendedEvents($user_id);
        } elseif ($select_type === "current") {
        	
        	$events = $db->getCurrentEvents();
        }


       
        if($events !== false){

            $response["error"]="false";
            $response["message"]='Events retrieved';
            $response["events"] = $events;
        }else{
            $response["error"]="true";
            $response["message"]='Could not create new user';
            $response["events"] = "";
        }
     
    }else{
        $response["error"]="true";
        $response["message"]="You are not authorized";
        $response["events"] = "";
    }
echo json_encode($response);
        

?>
