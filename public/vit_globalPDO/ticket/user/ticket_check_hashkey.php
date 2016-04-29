<?php
 
/*
 * Following code will get single event data
 * An event is identified by event id (eventId)
 */

$basedir = realpath(__DIR__);
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

// check for post data
if (isset($_POST["TICKETHASHKEY"])) {

	$ticketHashKey = $_POST['TICKETHASHKEY'];

	if(isset($_POST["EVENTID"])){
		$eventId = $_POST['EVENTID'];

		$params = 	[
					":eventId" => $eventId,
					":ticketHashKey" => $ticketHashKey
					];
		$query = "	SELECT EVENTNAME, TICKETTYPENAME, EVENTSTART, EVENTEND, TICKETSCANNED, TICKETID
     				FROM VIT_TICKET_PURCHASED 
     				INNER JOIN VIT_TICKETTYPE 
     				ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID 
     				INNER JOIN VIT_EVENT 
     				ON VIT_EVENT.EVENTID = VIT_TICKETTYPE.EVENTID 
     				WHERE VIT_EVENT.EVENTID = :eventId
     				AND TICKETHASHKEY = :ticketHashKey";
	
	} else if(isset($_POST["USERID"])) {
		$userId = $_POST['USERID'];
		$params = 	[
					":userId" => $userId,
					":ticketHashKey" => $ticketHashKey
					];
		$query = "	SELECT EVENTNAME, TICKETTYPENAME, EVENTSTART, EVENTEND, TICKETSCANNED, TICKETID
     				FROM VIT_TICKET_PURCHASED 
     				INNER JOIN VIT_TICKETTYPE 
     				ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID 
     				INNER JOIN VIT_EVENT 
     				ON VIT_EVENT.EVENTID = VIT_TICKETTYPE.EVENTID 
     				WHERE VIT_EVENT.USERID = :userId
     				AND TICKETHASHKEY = :ticketHashKey";
	}

	$db->executeMySQL($query, $params);

	if($db->rowCount() > 0){

		$result = $db->fetchObj();

		$start = (new DateTime($result->EVENTSTART))->format('Y-m-d H:i:s');
	   	$end = (new DateTime($result->EVENTEND))->format('Y-m-d H:i:s');
		$today = (new DateTime('now'))->format('Y-m-d H:i:s');

		if($today <= $end){

			$db->response["ticketScanned"] = $result->TICKETSCANNED;

			if($today >= $start){
				$ticketId = $result->TICKETID;
				$params2 = 	[
							":today" => $today,
							":ticketId" => $ticketId
							];
				$query2 = 	"	UPDATE VIT_TICKET_PURCHASED 
				        		SET TICKETSCANNED = :today
				 				WHERE TICKETID = :ticketId";
			}

			$db->response["eventName"] = $result->EVENTNAME;
        	$db->response["ticketTypeName"] = $result->TICKETTYPENAME;
			$db->response["success"] = 3;
			$db->echoSuccess();
		} else {
			$db->response["success"] = 2;
			$db->echoSuccess();
		}
	} else {
		$db->response["success"] = 1;
		$response["msg"] = 1;
		$db->echoSuccess();
	}

} else {
	$db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();
}
?>