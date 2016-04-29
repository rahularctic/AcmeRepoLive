<?php

/*
 * Following code will check if anyone is attending the chosen event
 * Event is determined by eventId
 * User is determined by userId
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["USERID"]) && isset($_POST["EVENTID"])) {

	 $userId = $_POST['USERID'];
	 $eventId = $_POST['EVENTID'];

	 $params = 	[
			 	":eventId" => $eventId,
			 	":userId" => $userId
	 			];
	 $result = "	SELECT USERID
	 				FROM VIT_USERATTENDING
	 				WHERE USERID = :userId AND EVENTID = :eventId";
	 
	 $db->executeMySQL($result, $params);
	 $db->echoBoolean("eventAttending");
} else {
  	$db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred"; 
	$db->echoSuccess();
}
	
	
?>