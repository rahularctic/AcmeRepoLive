<?php
 
/*
 * Following code will get all events based on todays date 
 * Selects all events by type
 */
 
// ============================================================
// INCLUDE
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


	
	$result = mysql_query("SELECT VIT_EVENT. * , VIT_USER.USERNAME, COUNT( VIT_USERATTENDING.EVENTID ) AS event_count
			       FROM VIT_USERATTENDING
			       INNER JOIN VIT_EVENT ON VIT_EVENT.EVENTID = VIT_USERATTENDING.EVENTID
			       INNER JOIN VIT_USER ON VIT_EVENT.USERID = VIT_USER.USERID
			       GROUP BY VIT_USERATTENDING.EVENTID
			       ORDER BY event_count DESC") or die(mysql_error()); 
	
	
	// check for empty result
	if (mysql_num_rows($result) > 0) {
		// looping through all results
		// events node
		$response["Event"] = array();
	 
		while ($row = mysql_fetch_array($result)) {
			// temp user array
			$event = array();
			$eventId = $row["EVENTID"];
			$event["eventId"] = $eventId;	
			$event["eventName"] = $row["EVENTNAME"];
			$event["eventDescription"] = $row["EVENTDESCRIPTION"];
			$event["eventStart"] = $row["EVENTSTART"];
			$event["eventEnd"] = $row["EVENTEND"];
			$event["eventLocation"] = $row["EVENTLOCATION"];
			$event["eventType"] = $row["EVENTTYPEID"];
			$event["eventLatitude"] = $row["EVENTLATITUDE"];
			$event["eventLongitude"] = $row["EVENTLONGITUDE"];
			$event["userId"] = $row["USERID"];
			$event["userName"] = $row["USERNAME"];
			$event["eventTime"] = "";
		
			$dtB = new DateTime($event['eventEnd']);
			$today = new DateTime('now');
		       
		 	if($today < $dtB) {
		        	// push single event into final response array
		      		array_push($response["Event"], $event);
			} 
		}
	
		// success
		$response["success"] = 1;
	 
		// echoing JSON response
		echo json_encode($response);
	} else {
	
		// no events found
		$response["success"] = 0;
	 
		// echo no users JSON
		echo json_encode($response);
	}
?>