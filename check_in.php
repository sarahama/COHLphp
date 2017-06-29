<?php
 
class CheckIn
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
 
// Hello

    //Function to check for an existing user
    public function checkinExists($user_id, $event_id) {
        $stmt = $this->conn->prepare("SELECT Attendance_ID FROM `Event_Attendance` WHERE User_ID = ? AND Event_ID = ?");
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

    public function checkCode($event_id, $code){
        $stmt = $this->conn->prepare("SELECT Event_Points FROM `Event` WHERE Event_ID = ? AND Event_Code = ?");
        $stmt->bind_param("is", $event_id, $code);
        $result = $stmt->execute();
        $stmt->bind_result($points);

        $get_result = $stmt->fetch();

        $stmt->close();

        
        if ($get_result) {
            return $points;
        } else {
            return false;
        }
    }
    //Function to create a new interest
    public function checkIntoEvent($user_id, $event_id, $code)
    {
        // the user has not checked in and the code is correct
        if (!$this->checkinExists($user_id, $event_id)) {
            $points = $this->checkCode($event_id, $code);
            if ($points !== false) {
                // give the user their points
                if ($this->updateUserPoints($user_id, $points)) {

                    //create an attendance record
                    $stmt = $this->conn->prepare("INSERT INTO Event_Attendance(User_ID, Event_ID) values(?, ?)");
                    $stmt->bind_param("ii", $user_id, $event_id);
                    
                    $result = $stmt->execute();
                    $stmt->close();
                    if ($result) {
                        return true;
                    } 
                }
            }
        }
        return false;
    }

    public function updateUserPoints($user_id, $points){
            $stmt = $this->conn->prepare("UPDATE USER 
                                        SET Current_Points = Current_Points + ?, 
                                            Total_Points = Total_Points + ? 
                                        WHERE User_ID = ?");
            $stmt->bind_param("iii", $points, $points, $user_id);
            
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
