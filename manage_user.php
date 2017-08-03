<?php
 
 //creating response array
	$response = array(
    "error" => "",
    "message" => "",
    "user" => "" 
    );
    //including the db operation file
    require_once "createUserWOFB.php";
    $db = new CreateUserWOFB();


  
    if($_SERVER['REQUEST_METHOD']==='POST'){
        
     	$user = false;
        //getting the request
        $select_type = $_POST["select_type"];
        
        if ($select_type === "sign_in_user") {
        	// if the request is to sign in the user

            $email = trim($_POST["email"]);
            $pass = trim($_POST["password"]);

            // make sure the user entered info
            if($email === "" || $pass === ""){
                $response["error"]="true";
                $response["message"]="Invalid login";
                $response["user"] = $user;
            } else {
                // otherwise try to log the user in
        	    $user = $db->userLogin($email, $pass);

                if($user === false){
                    $response["error"]="true";
                    $response["message"]="Invalid login";
                    $response["user"] = $user;
                }
            }
        } elseif ($select_type === "sign_up_user") {
            // if the request is to sign up a new user

            // get the post parameters
            $email = trim($_POST["email"]);
            $pass = trim($_POST["password"]);
            $conf_pass = trim($_POST["confirm_password"]);
            $name = trim($_POST["name"]);

            // make sure the user provided valid input
            if ($pass !== $conf_pass){
                $response["error"]="true";
                $response["message"]="Passwords must match";
                $response["user"] = "";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response["error"]="true";
                $response["message"]="Invalid email";
                $response["user"] = "";
            } elseif ($name === "" || $pass === "" || $email === "") {
                $response["error"]="true";
                $response["message"]="Fill out all fields";
                $response["user"] = "";
            } elseif (strlen($pass) < 6) {
                $response["error"]="true";
                $response["message"]="Passwords must be at least 6 characters";
                $response["user"] = "";
            } else {
                // if the input is valid try to create the new user
                $user = $db->createUser($email, $pass, $name);
                
                if($user === false){
                    // if the sign up fails, most likely the email is already registered
                    $response["error"]="true";
                    $response["message"]="Email already registered";
                    $response["user"] = $user;
                }
            }

        }

        // if the sign up or sign in was successful, return the info
        if($user !== false){
            $response["error"]="false";
            $response["message"]='User retrieved';
            $response["user"] = $user;
        }
     
    }else{
        //if it was not a post request, return information
        $response["error"]="true";
        $response["message"]="You are not authorized";
        $response["user"] = "";
    }

echo json_encode($response);
        

?>
