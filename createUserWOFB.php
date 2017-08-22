<?php

class CreateUserWOFB
{
    private $conn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/config_db.php';
        require_once dirname(__FILE__) . '/connect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    // verify the user
    public function userLogin($email, $pass)
    {
        // encrypt
        $password = md5($pass);
        $stmt = $this->conn->prepare("SELECT User_ID FROM User WHERE Email = ? AND Password = ?");
        $stmt->bind_param("ss", $email, $password);
        $result = $stmt->execute();
        $stmt->bind_result($user);
        
        $get_result = $stmt->fetch();

        $stmt->close();
     
        if ($get_result) {
            return $user;
        } else {
            return false;
        }
    }


    public function createUser($email, $pass, $first_name, $phone)
    {
        if (!$this->userExists($email)) {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO User (password, email, first_name, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $password, $email, $first_name, $phone);
            
            if ($stmt->execute()) {
                $stmt->close();
                return($this->conn->insert_id);

            } else {
                $stmt->close();
                return false;
            }

        } else {
            return false;
        }
    }


    private function userExists($email)
    {
        $stmt = $this->conn->prepare("SELECT User_ID FROM User WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // update the user's info
    public function updateUser($email, $name, $user_id){
        $stmt = $this->conn->prepare("UPDATE User 
                                    SET First_Name = ?, Email = ?
                                    WHERE User_ID = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;

        } else {
            $stmt->close();
            return false;
        }

    }

    public function getUserInfo($user_id) {
        $user = array();
        $tempArray = array();
        $stmt = $this->conn->prepare("SELECT * FROM User WHERE User_ID = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                array_push($user, $tempArray);
            }
            $stmt->close();
        
            return $user;
        } else {
            return false;
        }
    }


}