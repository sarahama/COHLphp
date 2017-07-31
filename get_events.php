<?php
 
class GetEvents
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
 

    //Function to get all events
    public function getAllUpcomingEvents() {
        $events = array();
        $tempArray = array();
        $stmt = $this->conn->prepare("SELECT * FROM Event WHERE Event_END_Date >= CURRENT_TIMESTAMP ORDER BY Event_Start_Date ASC");
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                $event_id = $tempArray->Event_ID;
                $interested_count = $this->getAllInterested($event_id);
                $tempArray->Count = $interested_count;
                array_push($events, $tempArray);
            }
            $stmt->close();
        
            return $events;
        } else {
            return false;
        }
    }


    //Function to get all events
    public function getCurrentEvents() {
        $events = array();
        $tempArray = array();
        $stmt = $this->conn->prepare("SELECT * FROM Event 
                                    WHERE Event_Start_Date <= CURRENT_TIMESTAMP 
                                    AND Event_End_Date >= CURRENT_TIMESTAMP
                                    ORDER BY Event_Start_Date ASC");
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                $event_id = $tempArray->Event_ID;
                $interested_count = $this->getAllInterested($event_id);
                $tempArray->Count = $interested_count;
                array_push($events, $tempArray);
            }
            $stmt->close();
        
            return $events;
        } else {
            return false;
        }
    }

    //Function to get events the user is interested in
    public function getInterestedEvents($user_id)
    {
        $events = array();
        $tempArray = array();
        $stmt = $this->conn->prepare('SELECT * FROM Event 
                                    INNER JOIN Event_Interest 
                                    ON Event.Event_ID = Event_Interest.Event_ID
                                    WHERE Event_Interest.User_ID = ?
                                    AND Event.Event_Start_Date >= CURRENT_TIMESTAMP 
                                    ORDER BY Event.Event_Start_Date ASC
                                    ');
      
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                $event_id = $tempArray->Event_ID;
                $interested_count = $this->getAllInterested($event_id);
                $tempArray->Count = $interested_count;
                array_push($events, $tempArray);
            }
            $stmt->close();
        
            return $events;
        } else {
            return false;
        }
    }

    //Function to get events the user has attended
    public function getAllAttendedEvents($user_id) {
        $events = array();
        $tempArray = array();
        $stmt = $this->conn->prepare("SELECT * FROM Event 
                                    INNER JOIN Event_Attendance 
                                    ON Event_Attendance.Event_ID = Event.Event_ID
                                    WHERE Event_Attendance.User_ID = ? 
                                    ORDER BY Event_Start_Date ASC");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                $event_id = $tempArray->Event_ID;
                $interested_count = $this->getAllInterested($event_id);
                $tempArray->Count = $interested_count;
                array_push($events, $tempArray);
            }
            $stmt->close();
        
            return $events;
        } else {
            return false;
        }
    }

    // Return the number of people interested in a particular event
    public function getAllInterested($event_id){
        $events = array();
        $tempArray = array();
        $stmt = $this->conn->prepare("SELECT * FROM Event_Interest
                                    WHERE Event_ID = ?");
        $stmt->bind_param("i", $event_id);
        if ($stmt->execute()) {
            $count = 0;
            $results = $stmt->get_result();
            while($results->fetch_object()){
                $count = $count + 1;
            }
            $stmt->close();
        
            return $count;
        } else {
            return false;
        }

    }
 
}
?>