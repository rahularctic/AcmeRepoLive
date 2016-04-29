<?php
 
/*
 * Following code will list all the events on the database
 */

$basedir = realpath(__DIR__);
// include db connect class
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

  
// check for post data
if (isset($_POST["DATE"])) {
$date = $_POST['DATE'];

/*    ob_start();
    $db->response["success"] = 1;
    $db->response["message"] = "inside if value of date is :".$date;
    $db->echoSuccess();
    //this is for the buffer achieve the minimum size in order to flush data

    ob_flush(); flush();*/


if (isset($_POST["EVENTTYPEID"])) {
    $eventType = $_POST['EVENTTYPEID'];



	
    $params = [":eventType" => $eventType, ":date" => $date ];
		// get all events from events table sort by category
		$query = "	SELECT VIT_EVENT.*, VIT_USER.USERNAME 
					FROM blueharl_vitee_db.VIT_EVENT
					INNER JOIN blueharl_vitee_db.VIT_USER
					ON VIT_EVENT.USERID = VIT_USER.USERID
					WHERE EVENTTYPEID = :eventType
					AND :date BETWEEN DATE(EVENTSTART) AND DATE(EVENTEND)
					ORDER BY EVENTSTART ASC ";

	} else {

        $params = [":date" => $date];
		// get all events from event table
		$query = "	SELECT VIT_EVENT.*, VIT_USER.USERNAME 
					FROM VIT_EVENT 
					INNER JOIN VIT_USER 
					ON VIT_EVENT.USERID = VIT_USER.USERID 
					WHERE :date BETWEEN DATE(EVENTSTART) AND DATE(EVENTEND)
					ORDER BY EVENTSTART ASC ";
	}
	

	$db->executeMySQL($query, $params);

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