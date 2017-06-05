<?php
 
class CreateNewUser
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
    public function userExists($fb_id) {
        $stmt = $this->conn->prepare("SELECT User_ID FROM `User` WHERE FB_ID = ?");
        $stmt->bind_param("s", $fb_id);
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

    //Function to create a new user, either returns an existing user's id or the new user id
    public function createUser($first_name, $fb_id)
    {
        $user_exists_id = $this->userExists($fb_id);
       
        if ($user_exists_id === false) {

            $stmt = $this->conn->prepare("INSERT INTO User(First_Name, FB_ID, Date_Joined, Last_Login) values(?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
            $stmt->bind_param("ss", $first_name, $fb_id);
            
            
            if ($stmt->execute()) {
                $stmt->close();
                return($this->conn->insert_id);

            } else {
                $stmt->close();
                return false;
            }
        } else {
            return $user_exists_id;
        }
    }
 
}
?>