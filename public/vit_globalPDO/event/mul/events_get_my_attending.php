<?php
 
/*
 * Following code will list all the events that the user is attending
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

// check for post data
if (isset($_POST["USERID"])) {

	$userId = $_POST['USERID'];
	
	$params = [":userId" => $userId];


	$query = "	SELECT *
				FROM VIT_EVENT
				INNER JOIN VIT_USERATTENDING
				ON VIT_EVENT.EVENTID = VIT_USERATTENDING.EVENTID
				INNER JOIN VIT_USER
				ON VIT_EVENT.USERID = VIT_USER.USERID
				WHERE VIT_USERATTENDING.USERID = :userId AND EVENTEND > CURDATE()";
				

	if (isset($_POST["switch"])){
		$switch = $_POST['switch'];

		if ($switch == 1) {

			$query = "	SELECT *
						FROM VIT_EVENT
						INNER JOIN VIT_USERATTENDING
						ON VIT_EVENT.EVENTID = VIT_USERATTENDING.EVENTID
						INNER JOIN VIT_USER
						ON VIT_EVENT.USERID = VIT_USER.USERID
						WHERE VIT_USERATTENDING.USERID = :userId AND EVENTPAID = 0 AND EVENTEND > CURDATE()";

		} else if ($switch == 2) {

			$query = "	SELECT *
						FROM VIT_EVENT
						INNER JOIN VIT_USERATTENDING
						ON VIT_EVENT.EVENTID = VIT_USERATTENDING.EVENTID
						INNER JOIN VIT_USER
						ON VIT_EVENT.USERID = VIT_USER.USERID
						WHERE VIT_USERATTENDING.USERID = :userId AND EVENTPAID = 1 AND EVENTEND > CURDATE()";
		}
	}
	
	$db->executeMySQL($query, $params);
	 
	if($db->rowCount() > 0){
		$db->echoFull("Event");
	} else {
		$db->response["success"] = 0;
	  	$db->echoSuccess();
	}
	

// End Isset
} else {
	$db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();
}

?>