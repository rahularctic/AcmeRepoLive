<?php
 
/*
 * Following code will mark the scanned timestamp for an individual ticketID
 */

$basedir = realpath(__DIR__);

// include db connect class
include($basedir . '/../../Template.php');

// check for post data
if (isset($_POST["ticketId"])) {

 // ============================================================
 // VARIABLES
 // ============================================================
	$ticketID = $_POST['ticketID'];
 	
 
 	$query = mysql_query("UPDATE VIT_TICKET_PURCHASED 
		        			SET TICKETSCANNED = 1
	     					WHERE TICKETID = '$ticketID'");

    // ============================================================
    // UPDATE TICKET SCANNED
    // ============================================================

    updateAndResponse($query);

} else {
	// required field is missing
	$response["success"] = false;
	$response["message"] = "Oops, an error occurred";
		
	// echo no users JSON
	echo json_encode($response);
}
?>