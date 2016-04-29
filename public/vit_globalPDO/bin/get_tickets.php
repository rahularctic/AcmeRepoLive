<?php
 
/*
 * Following code will get single event data
 * An event is identified by event id (eventId)ssss
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

    // get an event from Event table
    $result = mysql_query("SELECT VIT_TICKET_PURCHASED.*, TICKETTYPENAME, VIT_EVENT.EVENTID, EVENTNAME, EVENTLOCATION, EVENTSTART, EVENTEND, USERNAME
    				FROM VIT_TICKET_PURCHASED INNER JOIN VIT_TICKETTYPE 
				ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID 
				INNER JOIN VIT_EVENT
				ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
				INNER JOIN VIT_USER
				ON VIT_EVENT.USERID = VIT_USER.USERID 
				WHERE VIT_TICKET_PURCHASED.USERID = $userId
                                ORDER BY EVENTSTART");
    
    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
 
            // user node
            $response["Ticket"] = array();
        
	    while($row = mysql_fetch_array($result)){
	        
		        $ticket = array();
		        $ticket["eventId"] = $row["EVENTID"];
		        $ticket["ticketId"] = $row["TICKETID"];
		        $ticket["eventName"] = $row["EVENTNAME"];
		        $ticket["ticketTypeName"] = $row["TICKETTYPENAME"];
		        $ticket["eventLocation"] = $row["EVENTLOCATION"];
		        $ticket["eventStart"] = $row["EVENTSTART"];
		        $ticket["ticketHashKey"] = $row["TICKETHASHKEY"];
		        $ticket["userName"] = $row["USERNAME"];
		
			$dtB = new DateTime($row['EVENTEND']);
			$today = new DateTime('now');
		   
			if($today < $dtB) {
				// push single event into final response array
				array_push($response["Ticket"], $ticket);
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