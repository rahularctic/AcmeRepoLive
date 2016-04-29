<?php
 
/*
 * Following code will list all the events
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

    $query = "	SELECT VIT_EVENT. * , VIT_USER.USERNAME, VIT_USER.USERIMAGE , COUNT( VIT_USERATTENDING.EVENTID ) AS event_count
			   	FROM VIT_USERATTENDING
			   	INNER JOIN VIT_EVENT ON VIT_EVENT.EVENTID = VIT_USERATTENDING.EVENTID
			   	INNER JOIN VIT_USER ON VIT_EVENT.USERID = VIT_USER.USERID
			   	WHERE EVENTEND > CURDATE()
			   	GROUP BY VIT_USERATTENDING.EVENTID
			   	ORDER BY event_count DESC
			   	LIMIT 0, 10";
	
	$db->executeMySQL($query);
	 
	if($db->rowCount() > 0){
		$db->echoFull("Event");
		exit;
	} else {

		$query = "	SELECT VIT_EVENT. * , VIT_USER.USERNAME, VIT_USER.USERIMAGE
					FROM VIT_EVENT
					INNER JOIN VIT_USER ON VIT_EVENT.USERID = VIT_USER.USERID
					WHERE EVENTEND > CURDATE()
					ORDER BY EVENTEND DESC
					LIMIT 0, 10";

		$db->executeMySQL($query);

		if($db->rowCount() > 0){
			$db->echoFull("Event");
			exit;
		} else {
			$db->response["success"] = 0;
			$db->echoSuccess();
		}
	}

?>