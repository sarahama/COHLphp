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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1

CREATE TABLE `Event_Interest` (
 `Interest_ID` int(11) NOT NULL AUTO_INCREMENT,
 `Event_ID` int(11) NOT NULL,
 `User_ID` int(11) NOT NULL,
 PRIMARY KEY (`Interest_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1