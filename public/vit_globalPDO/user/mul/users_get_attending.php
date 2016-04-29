<?php

$basedir = realpath(__DIR__);
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["EVENTID"])) {
	$eventId = $_POST['EVENTID'];

	$params = 	[
				":eventId" => $eventId
				];

	if (isset($_POST["USERID"])) {
		$userId = $_POST['USERID'];

		$params1 = 	[
			":eventId" => $eventId,
			":userId" => $userId
		];

		$query1 = "SELECT * FROM VIT_USERATTENDING WHERE EVENTID = :eventId";
		$db->executeMySQL($query1, $params);
		if($db->rowCount() > 0) {
			// People are attending so retrieve your friends if any are attending
			$db->response["UserCount"] = $db->rowCount();
			$query2 = "SELECT a.USERID, a.USERIMAGE
	 					FROM (SELECT VIT_USERATTENDING.USERID, VIT_USER.USERIMAGE FROM VIT_USERATTENDING
						      INNER JOIN VIT_USER ON VIT_USERATTENDING.USERID = VIT_USER.USERID
						      WHERE VIT_USERATTENDING.EVENTID = :eventId) AS a, VIT_FOLLOW b
	 					WHERE a.USERID = b.F_USERID AND b.USERID = :userId
	 					LIMIT 0,5";
			$db->executeMySQL($query2, $params1);
			if($db->rowCount() >0){
				// Your friends are going show them
				$db->echoFull("User");
			} else {
				// Your friends are not going, show random people
				$query3 = "SELECT VIT_USERATTENDING.USERID,VIT_USER.USERIMAGE
							FROM VIT_USERATTENDING
							INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_USERATTENDING.USERID
							WHERE VIT_USERATTENDING.EVENTID = :eventId AND VIT_USERATTENDING.USERID != :userId
							LIMIT 0,5";

				$db->executeMySQL($query3, $params1);
				if($db->rowCount() > 0) {
					$db->echoFull("User");
				} else {
					$db->response["success"] = 1;
					$db->response["User"] = [ "0" => ["USERID" => $userId] ];
					$db->echoSuccess();
				}
			}

		} else {
			// No one is attending
			$db->response["success"] = 0;
			$db->echoSuccess();
		}
	} else {
		// Userid is not posted so show the full list of attendees
		$query4 = "	SELECT *
					FROM VIT_USER
					INNER JOIN VIT_USERATTENDING ON VIT_USERATTENDING.USERID = VIT_USER.USERID
					WHERE VIT_USERATTENDING.EVENTID = :eventId";
		$db->executeMySQL($query4, $params);
		if($db->rowCount() > 0) {
			$db->echoFull("User");
		} else {
			$db->response["success"] = 0;
			$db->echoSuccess();
		}
	}

} else {
	// No one is attending
	$db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();
}
?>