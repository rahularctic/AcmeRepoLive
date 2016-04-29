<?php

/*
 * Following code will list all the events
 */

$basedir = realpath(__DIR__);
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["eventList"])) {

    $eventList = $_POST['eventList'];
    $list =  json_decode($eventList, true);

    $query = "  SELECT *
                FROM VIT_EVENT
                INNER JOIN VIT_USER
                ON VIT_EVENT.USERID = VIT_USER.USERID
                WHERE EVENTID IN (".implode(',',$list).")";

	$db->executeMySQL($query);

    if($db->rowCount() > 0){
        $db->echoFull("Event");
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