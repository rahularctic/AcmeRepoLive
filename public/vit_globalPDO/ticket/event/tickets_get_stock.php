<?php
 
/*
 * Following code will list all the Tickets
 */

$basedir = realpath(__DIR__);
// include db connect class
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

// check for post data
if (isset($_POST["EVENTID"])) {

    $eventId = $_POST['EVENTID'];

	$params = [":eventId" => $eventId];
    $query = "  SELECT * 
                FROM VIT_TICKETTYPE 
                INNER JOIN VIT_TICKETCU ON VIT_TICKETTYPE.TICKETCUID = VIT_TICKETCU.TICKETCUID 
                WHERE VIT_TICKETTYPE.EVENTID = :eventId AND TICKETENDSALES > CURDATE()";
	
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