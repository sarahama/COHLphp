CREATE TABLE `reward` (
 `Reward_ID` int(11) NOT NULL AUTO_INCREMENT,
 `Reward_Name` varchar(100) NOT NULL,
 `Reward_Cost` int(100) NOT NULL,
 `Reward_Stock` int(100) NOT NULL,
 `Reward_For_Sale` tinyint(1) NOT NULL,
 `Reward_Available_For_PickUp` tinyint(1) NOT NULL,
 PRIMARY KEY (`Reward_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1

CREATE TABLE `Redeem` (
 `Redeem_ID` int(11) NOT NULL AUTO_INCREMENT,
 `User_ID` int(11) NOT NULL,
 `Reward_ID` int(11) NOT NULL,
 `Redeem_Created` datetime NOT NULL,
 `Redeem_Picked_Up` date NOT NULL,
 `Redeem_Completed` tinyint(1) NOT NULL,
 PRIMARY KEY (`Redeem_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1

CREATE TABLE `Store` (
 `Store_ID` int(11) NOT NULL AUTO_INCREMENT,
 `Store_Name` varchar(100) NOT NULL,
 `Store_Open` tinyint(1) NOT NULL,
 `Store_Start` date NOT NULL,
 `Store_End` date NOT NULL,
 PRIMARY KEY (`Store_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1