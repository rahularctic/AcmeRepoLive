<?php

/*
 * Following code will allow a user to attend the specified event
 * The event is determined for the eventId
 * The user is determined by the userId
 */
 
$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if(isset($_POST['USERID']) && isset($_POST['EVENTID'])) {

	$userId = $_POST['USERID'];
	$eventId = $_POST['EVENTID'];
      
	$params = 	[
				":eventId" => $eventId,
				":userId" => $userId
				];
	$result = "	INSERT INTO VIT_USERATTENDING(USERID, EVENTID)
				VALUES(:userId,:eventId)";

    $db->executeMySQL($result, $params);
	$db->echoBoolean("success");

} else {
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred"; 
	$db->echoSuccess();
}

?>