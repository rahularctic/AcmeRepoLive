<?php

/*
 * Following code will list all the information of the ticket
 */

$basedir = realpath(__DIR__);
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["USERID"]) && isset($_POST["TICKETTYPEID"]) && isset($_POST["TICKETID"])) {

	$userId = $_POST['USERID'];
	$ticketTypeId = $_POST['TICKETTYPEID'];
	$ticketId = $_POST['TICKETID'];
	$params = 	[
	            ":userId" => $userId,
	            ":ticketTypeId" => $ticketTypeId,
	            ":ticketId" => $ticketId
	            ];

	$query = "	SELECT *
				FROM VIT_TICKETTYPE
				INNER JOIN VIT_TICKET_PURCHASED
				ON VIT_TICKETTYPE.TICKETTYPEID = VIT_TICKET_PURCHASED.TICKETTYPEID
			    INNER JOIN VIT_EVENT
			    ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
			    INNER JOIN VIT_USER
			    ON VIT_EVENT.USERID = VIT_USER.USERID 
			    WHERE VIT_TICKET_PURCHASED.USERID = :userId AND VIT_TICKET_PURCHASED.TICKETTYPEID = :ticketTypeId AND VIT_TICKET_PURCHASED.TICKETID = :ticketId";

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