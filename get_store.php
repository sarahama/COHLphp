<?php
 
class GetStore
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
    public function getAllRewards() {
        $rewards = array();
        $tempArray = array();
        $stmt = $this->conn->prepare("SELECT * FROM Reward WHERE Reward_For_Sale = 1");
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

    //Function to get the user's rewards
    public function getUserRewards($user_id) {
        $rewards = array();
        $tempArray = array();
        $stmt = $this->conn->prepare("SELECT * FROM Redeem INNER JOIN Reward on Redeem.Reward_ID = Reward.Reward_ID Where `User_ID` = ? ORDER BY `Redeem_Created` DESC");
        $stmt->bind_param("i", $user_id);
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


    // Function to create a new purchase
    // Will update the users points and update the stock
    // and insert a new record into redeem
    public function purchaseReward($user_id, $reward_id) {
        // check the item is in stock and for sale
        if ($this->reward_available($reward_id)) {

            $reward_points = $this->getRewardPoints($reward_id);
            $user_points = $this->getUsersPoints($user_id);
            // if they have enough points       
            if ($reward_points <= $user_points) {
                $points_updated = $this->subtractPoints($user_id, $reward_points);
                if ($points_updated !== false) {
                    
                    $updated_stock = $this->subtractStock($reward_id);
                    if ($updated_stock !== false) {
                        
                        $purchased = $this->createPurchase($user_id, $reward_id);
                        return $purchased; 
                    }
                }  
            }
        }
        return false;
    }

    //Function to create a new purchase
    public function createPurchase($user_id, $reward_id) {
        $stmt = $this->conn->prepare("INSERT INTO Redeem(User_ID, Reward_ID, Redeem_Created) values(?, ?, CURRENT_TIMESTAMP)");
        $stmt->bind_param("ii", $user_id, $reward_id);
            
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        }
        return false;
        
    }
        
    // check the reward is for sale and in stock
    public function reward_available($reward_id) 
    {
        $stmt = $this->conn->prepare("SELECT Reward_For_Sale, Reward_Stock FROM Reward WHERE Reward_ID = ?");
        $stmt->bind_param("s", $reward_id);
        if ($stmt->execute()) {
            $results = $stmt->get_result();
            $row = $results->fetch_object();
            if($row->Reward_For_Sale == 1 && $row->Reward_Stock > 0){
                return true;
            }
        }
        return false;
    }

    // check the user has enough points
    public function getUsersPoints($user_id)
    {
        $stmt = $this->conn->prepare("SELECT Current_Points FROM User WHERE User_ID = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $results = $stmt->get_result();
            $row = $results->fetch_object();
            return $row->Current_Points;
        }
        return false;
    }

    // update the users points
    public function subtractPoints($user_id, $reward_points){
        $stmt = $this->conn->prepare("UPDATE USER 
                                    SET Current_Points = Current_Points - ? 
                                    WHERE User_ID = ?");
        $stmt->bind_param("ii", $reward_points, $user_id);
        
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // get the points required for a reward
    public function getRewardPoints($reward_id){
        $stmt = $this->conn->prepare("SELECT Reward_Cost FROM Reward WHERE Reward_ID = ?");
        $stmt->bind_param("s", $reward_id);
        if ($stmt->execute()) {
            $results = $stmt->get_result();
            $row = $results->fetch_object();
            return $row->Reward_Cost;    
        }
        return false;
    }

    // update the reward stock
    public function subtractStock($reward_points){
        $stmt = $this->conn->prepare("UPDATE REWARD
                                    SET Reward_Stock = Reward_Stock - 1 
                                    WHERE Reward_ID = ?");
        $stmt->bind_param("i", $reward_id);
        
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