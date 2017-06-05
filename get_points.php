<?php
 
class UserPoints
{
    private $conn;
 
    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/config_db.php';
        require_once dirname(__FILE__) . '/connect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
 


    //Function to check for an existing user
    public function getUserPoints($user_id) {
        $points = array();
       
        $stmt = $this->conn->prepare("SELECT Total_Points, Current_Points FROM `User` WHERE User_ID = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            $row = $results->fetch_object();
            $points = $row;
            $stmt->close();
        
            return $points;
        } else {
            return false;
        }
    }
 
}
?>