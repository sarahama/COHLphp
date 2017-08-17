<?php
 
//creating response array
$response = array(
    "error" => "",
    "message" => "" 
    );


if($_SERVER['REQUEST_METHOD']==='POST'){
 
    //getting values
    $user_id = $_POST["user_id"];
    
    $subject = $_POST["subject"];

    $message = $_POST["message"];


    //including the db operation file
    require_once "new_feedback.php";
    $db = new CreateNewFeedback();
 
    //inserting values 
    if($db->createFeedback($user_id, $subject, $message)){
        $response["error"]="false";
        $response["message"]='Feedback saved successfully';
    }else{
 
        $response["error"]="true";
        $response["message"]='Could not submit feedback';
    }
 
}else{
    $response["error"]="true";
    $response["message"]="You are not authorized";
}
echo json_encode($response);
?>