<?php
 
class CreateNewFeedback
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
 

    //Function to create a new interest
    public function createFeedback($user_id, $subject, $message)
    {
        
        $stmt = $this->conn->prepare("INSERT INTO Feedback(User_ID, Subject, Message, Submitted_On) values(?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->bind_param("iss", $user_id, $subject, $message);
            
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
 
}
?>