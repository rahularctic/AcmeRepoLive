<?php
 
/*
 * Following code will search all the events where the event name is like the submitted string 
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
if (isset($_POST["searchParams"])) {

// ============================================================
// 			VARIABLES
// ============================================================
    $searchParams = $_POST['searchParams'];
    
    // search an event from Event table
    $result = mysql_query("SELECT *
    				FROM VIT_EVENT 
    				INNER JOIN VIT_USER
    				ON VIT_EVENT.USERID = VIT_USER.USERID
    				WHERE EVENTNAME 
    				LIKE '%$searchParams%'");
    
        // check for empty result
        if (mysql_num_rows($result) > 0) {
        
    		$response["Event"] = array();
         	while ($row = mysql_fetch_array($result)) {
 
			$search = array();
			$search["eventId"] = $row ["EVENTID"];
			$search["userId"] = $row ["USERID"];
			$search["userName"] = $row ["USERNAME"];
			$search["eventName"] = $row ["EVENTNAME"];
			$search["eventDescription"] = $row ["EVENTDESCRIPTION"];
			
			//$search["eventStartDate"] = $row ["EVENTSTARTDATE"];
			//$search["eventEndDate"] = $row ["EVENTENDDATE"];
			//$search["eventStartTime"] = $row ["EVENTSTARTTIME"];
			//$search["eventEndTime"] = $row ["EVENTENDTIME"];
			$search["eventStart"] = $row["EVENTSTART"];
			$search["eventEnd"] = $row["EVENTEND"];
		       	    
			$search["eventLocation"] = $row ["EVENTLOCATION"];
			$search["eventType"] = $row ["EVENTTYPE"];
	            
	            	$dtB = new DateTime($search['eventEnd']);
			$today = new DateTime('now');
   
			if($today < $dtB) {
				// push single event into final response array
				array_push($response["Event"], $search);
			}

            
		}
		// success
		$response["success"] = 1;
		
		// echoing JSON response
		echo json_encode($response);
		
        } else {
            // no product found
            $response["success"] = 0;
 
            // echo no users JSON
            echo json_encode($response);
        }
        
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Oops, an error occurred";
 
    // echoing JSON response
    echo json_encode($response);
}

?>