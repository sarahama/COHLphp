<?php
 
class GetFriends
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
 

    //Function to get the user's current friends
    public function getConnectedFriends($user_id) {
        $friends = array();
        $tempArray = array();

        // need to do 2 queries because they could be friend 1 or friend 2
        $stmt = $this->conn->prepare("SELECT User.First_Name, User.User_ID, User.Total_Points, Friends.Accepted FROM Friends 
                                        INNER JOIN User 
                                        ON Friends.Friend2 = User.User_ID
                                        WHERE Friends.Friend1 = ?
                                        AND Friends.Accepted = 1");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                array_push($friends, $tempArray);
            }
            $stmt->close();
        
        } else {
            return false;
        }


        // second query

        // need to do 2 queries because they could be friend 1 or friend 2
        $stmt2 = $this->conn->prepare("SELECT User.First_Name, User.User_ID, User.Total_Points, Friends.Accepted FROM Friends 
                                        INNER JOIN User 
                                        ON Friends.Friend1 = User.User_ID
                                        WHERE Friends.Friend2 = ?
                                        AND Friends.Accepted = 1");
        $stmt2->bind_param("i", $user_id);
        if ($stmt2->execute()) {

            $results = $stmt2->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                array_push($friends, $tempArray);
            }
            $stmt2->close();
        
        } else {
            return false;
        }

        // get pending requests, if they are receiving the request they are friend 2
        $stmt3 = $this->conn->prepare("SELECT User.First_Name, User.User_ID, User.Total_Points, Friends.Accepted FROM Friends 
                                        INNER JOIN User 
                                        ON Friends.Friend1 = User.User_ID
                                        WHERE Friends.Friend2 = ?
                                        AND Friends.Responded = 0");
        $stmt3->bind_param("i", $user_id);
        if ($stmt3->execute()) {

            $results = $stmt3->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                array_push($friends, $tempArray);
            }
            $stmt3->close();
        
        } else {
            return false;
        }


        return $friends;
    }


    // Function to get all friends they have not requested
    // only get people that have facebook accounts 
    // and they have in their contacts
    public function getUnconnectedFriends($user_id, $phone_list) {

        $friends = array();
        $tempArray = array();

        // check if the phone list is empty, if it is return an empty list
        if ($phone_list[0] == "") {
            return [];
        }

        // construct the list of phone numbers
        // take the list provided from their contacts, use the IN expression
        // take the list of users they are already connected to, use the NOT IN expression
        // this will only display new people they have not connected with
        $phone_string = "(";
        $i = 0;    
        $num_phones = count($phone_list);
        while ($i < $num_phones-2) {
            if ($phone_list[$i] !== ""){
                    $phone_string = $phone_string . " '" . trim($phone_list[$i]) . "',";
                }
            $i++;
        }
        // add on the last one without a comma at the end
        if ($num_phones > 1) {
            if ($phone_list[$num_phones-2] !== ""){
                $phone_string = $phone_string . " '" . trim($phone_list[$num_phones-2]) . "'";
            }
        }
        // close the expression
        $phone_string = $phone_string.")";


        // now get the id's of their current friends, we will not include these users
        $current_friends = $this->getConnectedFriends($user_id);
        $id_string = "AND User.User_ID NOT IN (";
        $num_friends = count($current_friends);
        $i = 0;
        while ($i < $num_friends-1) {
            $id_string = $id_string . " '" . trim($current_friends[$i]->User_ID) . "',";
            $i++;
        }
        // add on the last one without a comma at the end
        if ($num_friends > 0) {
            $id_string = $id_string . " '" . trim($current_friends[$num_friends-1]->User_ID) . "')";
        }

        $stmt = $this->conn->prepare("SELECT User.First_Name, User.User_ID, User.Total_Points FROM User 
                                    WHERE User.Phone IN " . $phone_string . $id_string .  "AND FB_ID is not NULL"); 

      
        if ($stmt->execute()) {

            $results = $stmt->get_result();
            while($row = $results->fetch_object()){
                $tempArray = $row;
                array_push($friends, $tempArray);
            }
            $stmt->close();
        
            return $friends;
        } else {
            return false;
        }
    }

    //Function to accept or deny a request
    public function respondToRequest($user_id, $friend_id, $accept)
    {
        // friend 1 is the one who sent the request, 2 is responding
        $stmt = $this->conn->prepare('UPDATE Friends 
                                    SET Accept = ?, Responded = 1
                                    WHERE Friend1 = ?
                                    AND Friend2 = ? 
                                    ');
      
        $stmt->bind_param("iii", $accept, $friend_id, $user_id);
        if ($stmt->execute()) {
            $stmt->close();
        
            return true;
        } else {
            return false;
        }
    }

    // Send a friend request
    public function sendFriendRequest($user_id, $friend_id) {

        // friend 1 is the one who sent the request, 2 is responding
        $stmt = $this->conn->prepare("INSERT INTO Friends(Friend1, Friend2, Responded) values(?, ?, 0)");
        $stmt->bind_param("ii", $user_id, $friend_id);
        if ($stmt->execute()) {
            $stmt->close();
        
            return true;
        } else {
            return false;
        }
    }

 
}
?>