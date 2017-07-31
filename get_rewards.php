<?php
 
class GetRewards
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
 

    //Function to get all rewards
    public function getUserRewards($user_id){
        $rewards = array();
        $tempArray = array();
        $stmt = $this->conn->prepare("SELECT * FROM Redeem WHERE User_ID = ?");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                array_push($rewards, $tempArray);
            }
            $stmt->close();
        
            return $rewards;
        } else {
            return false;
        }
    }
}