<?php
 
class CreateNewInterest
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
    public function interestExists($user_id, $event_id) {
        $stmt = $this->conn->prepare("SELECT Interest_ID FROM `Event_Interest` WHERE User_ID = ? AND Event_ID = ?");
        $stmt->bind_param("ii", $user_id, $event_id);
        $result = $stmt->execute();
        $stmt->bind_result($user);
        
        $get_result = $stmt->fetch();

        $stmt->close();

        
        if ($get_result) {
            return true;
        } else {
            return false;
        }
    }

    //Function to create a new interest
    public function createInterest($user_id, $event_id)
    {
        if (!$this->interestExists($user_id, $event_id)) {
            $stmt = $this->conn->prepare("INSERT INTO Event_Interest(User_ID, Event_ID) values(?, ?)");
            $stmt->bind_param("ii", $user_id, $event_id);
            
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }

    //Function to delete an interest
    public function deleteInterest($interest_id)
    {
        if ($this->interestExists($user_id, $event_id)) {
            $stmt = $this->conn->prepare("DELETE FROM Event_Interest WHERE Interest_ID = ?");
            $stmt->bind_param("i", $interest_id);
            
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
 
}
?>