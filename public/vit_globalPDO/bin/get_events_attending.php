<?php
 
/*
 * Following code will get events that the user is attending
 */
 
// ============================================================
// 			INCLUDE
// ============================================================

$basedir = realpath(__DIR__);

// include db connect class
require_once($basedir . '/../../config/db_connect.php');
 
// connecting to db
$db = new DB_CONNECT();
   
// array for JSON response
$response = array();

// minor fix for description characters
mysql_set_charset("utf8");

// check for post data
if (isset($_POST["userId"])) {

// ============================================================
// 			VARIABLES
// ============================================================
   	$userId = $_POST['userId'];
 	
    	
	// get event from events table
	$query = mysql_query("SELECT * 
				FROM VIT_EVENT INNER JOIN VIT_USERATTENDING 
				ON VIT_EVENT.EVENTID = VIT_USERATTENDING.EVENTID 
				INNER JOIN VIT_USER 
				ON VIT_USER.USERID = VIT_EVENT.USERID 
				WHERE VIT_USERATTENDING.USERID = '$userId'") or die(mysql_error());

	// check for empty result
	if (mysql_num_rows($query) > 0) {
	
    		// looping through all results
    		$response["Event"] = array();
    		while ($row = mysql_fetch_array($query)) {
	    			
	        	// temp user array
	        	$event = array();
        		$event["userId"] = $row["USERID"];
			$event["userName"] = $row["USERNAME"];
	        	$event["eventId"] = $row["EVENTID"];	
			$event["eventName"] = $row["EVENTNAME"];
			
	        	//$event["eventStartDate"] = $row["EVENTSTARTDATE"];
	        	//$event["eventEndDate"] = $row["EVENTENDDATE"];
	        	//$event["eventStartTime"] = $row["EVENTSTARTTIME"];
	        	//$event["eventEndTime"] = $row["EVENTENDTIME"];
			$event["eventStart"] = $row["EVENTSTART"];
			$event["eventEnd"] = $row["EVENTEND"];
	        	
	       		$event["eventLocation"] = $row["EVENTLOCATION"];
	        	$event["eventType"] = $row["EVENTTYPE"];
	        	$event["eventLatitude"] = $row["EVENTLATITUDE"];
	        	$event["eventLongitude"] = $row["EVENTLONGITUDE"];
	     		$event["eventTime"] = "";
		
			$dtB = new DateTime($event['eventEnd']);
			$today = new DateTime('now');
		   
			if($today < $dtB) {
				// push single event into final response array
				array_push($response["Event"], $event);
			}
				
		}
        	
	    	// successfuly found events
		$response["success"] = 1;
		echo json_encode($response);
        	
    	} else {
    	
	    	// no events found
	    	$response["success"] = 0;
	    	echo json_encode($response);
	}
    	
} else {

	// req fields missing
	$response["success"] = 0;
	$response["message"] = "Oops, an error occurred";
	echo json_encode($response);
}
?>