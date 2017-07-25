<?php
 
// Create connection
$con=mysqli_connect("localhost","root","","COHL");
 
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
// This SQL statement selects ALL from the table 'Locations'
$sql = "SELECT * FROM Event WHERE Event_Start_Date >= CURRENT_TIMESTAMP ORDER BY Event_Start_Date ASC";
 
// Check if there are results
if ($result = mysqli_query($con, $sql))
{
	// If so, then create a results array and a temporary one
	// to hold the data
	$resultArray = array();
	$tempArray = array();
 
	// Loop through each row in the result set
	while($row = $result->fetch_object())
	{
		// Add each row into our results array
		$tempArray = $row;
	    array_push($resultArray, $tempArray);
	}
 
 	$events = array(
 		"events" => $resultArray,
 		);
	// Finally, encode the array to JSON and output the results
	echo json_encode($events);
}
 
// Close connections
mysqli_close($con);
?>