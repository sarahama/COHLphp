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

CREATE TABLE `Friends` (
 `Friend1` int(10) NOT NULL,
 `Friend2` int(10) NOT NULL,
 `Responded` bit(1) DEFAULT NULL,
 `Accepted` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE `Feedback` (
 `Feedback_ID` int(11) NOT NULL AUTO_INCREMENT,
 `User_ID` int(11) NOT NULL,
 `Subject` varchar(150) NOT NULL,
 `Message` varchar(500) NOT NULL,
 `Submitted_On` datetime NOT NULL,
 PRIMARY KEY (`Feedback_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1

CREATE TABLE `User` (
 `User_ID` int(11) NOT NULL AUTO_INCREMENT,
 `FB_ID` varchar(100) DEFAULT NULL,
 `First_Name` varchar(100) NOT NULL,
 `Last_Name` varchar(100) DEFAULT NULL,
 `Date_Joined` datetime NOT NULL,
 `Last_Login` datetime NOT NULL,
 `Access_Token` varchar(200) DEFAULT NULL,
 `School` varchar(100) DEFAULT NULL,
 `Current_Points` int(11) NOT NULL DEFAULT '0',
 `Total_Points` int(11) NOT NULL DEFAULT '0',
 `On_Leader_Board` bit(1) DEFAULT NULL,
 `Email` varchar(100) NOT NULL,
 `Password` varchar(300) NOT NULL,
 `Profile_Path` blob NOT NULL,
 `Phone` varchar(16) NOT NULL,
 PRIMARY KEY (`User_ID`),
 UNIQUE KEY `Access_Token` (`Access_Token`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1

CREATE TABLE `Event` (
 `Event_ID` int(11) NOT NULL AUTO_INCREMENT,
 `Event_Start_Date` datetime NOT NULL,
 `Event_Name` varchar(100) NOT NULL,
 `Event_Details` varchar(200) NOT NULL,
 `Event_Color` varchar(20) NOT NULL,
 `Event_Organization` int(11) NOT NULL,
 `Event_Points` int(11) NOT NULL,
 `Event_Code` varchar(200) NOT NULL,
 `Event_Address` varchar(100) NOT NULL,
 `Event_City` varchar(100) NOT NULL,
 `Event_State` varchar(2) NOT NULL,
 `Event_Zip` int(11) NOT NULL,
 `Event_End_Date` datetime NOT NULL,
 PRIMARY KEY (`Event_ID`),
 UNIQUE KEY `Event_ID` (`Event_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1

CREATE TABLE `Event_Attendance` (
 `Attendance_ID` int(11) NOT NULL AUTO_INCREMENT,
 `User_ID` int(11) NOT NULL,
 `Event_ID` int(11) NOT NULL,
 PRIMARY KEY (`Attendance_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1

CREATE TABLE `Event_Interest` (
 `Interest_ID` int(11) NOT NULL AUTO_INCREMENT,
 `Event_ID` int(11) NOT NULL,
 `User_ID` int(11) NOT NULL,
 PRIMARY KEY (`Interest_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1

