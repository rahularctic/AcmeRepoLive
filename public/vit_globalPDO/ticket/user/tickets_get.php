<?php
 
/*
 * Following code will get single event data
 * An event is identified by event id (eventId)ssss
 */
 
$basedir = realpath(__DIR__);
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["USERID"])) {

    $userId = $_POST['USERID'];

    $params =   [
                ":userId" => $userId
                ];
    $query = "  SELECT VIT_TICKET_PURCHASED.*, TICKETTYPENAME, VIT_EVENT.EVENTID, EVENTNAME, EVENTLOCATION, EVENTSTART, EVENTEND, USERNAME
    			FROM VIT_TICKET_PURCHASED 
                INNER JOIN VIT_TICKETTYPE 
				ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID 
				INNER JOIN VIT_EVENT
				ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
				INNER JOIN VIT_USER
				ON VIT_EVENT.USERID = VIT_USER.USERID 
				WHERE VIT_TICKET_PURCHASED.USERID = :userId AND VIT_EVENT.EVENTEND > CURDATE()
                ORDER BY EVENTSTART";

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