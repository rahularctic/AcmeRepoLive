<?php

/*
 * Following code will allow users to un-attend the events that they are attending already 
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
    $result = "	DELETE FROM VIT_USERATTENDING
    			WHERE EVENTID = :eventId AND USERID = :userId";

    $db->executeMySQL($result, $params);
	$db->echoBoolean("success");

} else {
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred"; 
	$db->echoSuccess();
}

?>