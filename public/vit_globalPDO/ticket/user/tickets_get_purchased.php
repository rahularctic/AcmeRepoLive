<?php
 
/*
 * Following code will list all the Tickets for a certain event
 */

$basedir = realpath(__DIR__);
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["USERID"]) && isset($_POST["EVENTID"])) {

	$userId = $_POST['USERID'];
	$eventId = $_POST['EVENTID'];
	$params = 	[
	            ":userId" => $userId,
	            ":eventId" => $eventId
	            ];

	$query = "SELECT TICKETID, TICKETHASHKEY, TICKETSCANNED, TICKETTYPENAME, VIT_TICKETTYPE.TICKETTYPEID
			  FROM VIT_TICKET_PURCHASED
			  INNER JOIN VIT_TICKETTYPE
			  ON VIT_TICKETTYPE.TICKETTYPEID = VIT_TICKET_PURCHASED.TICKETTYPEID
			  WHERE VIT_TICKET_PURCHASED.USERID = :userId AND VIT_TICKETTYPE.EVENTID = :eventId ";
	    
    $db->executeMySQL($query, $params);

    if($db->rowCount() > 0){
    	$db->echoFull("Ticket");
    } else {
    	$db->response["success"] = 0;
    	$db->echoSuccess();
    }

} else {
	$db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}

?>














