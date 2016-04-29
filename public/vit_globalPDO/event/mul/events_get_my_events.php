<?php
 
/*
 * Following code will list all the events
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

// check for post data
if (isset($_POST["USERID"])) {

    $userId = $_POST['USERID'];

	$params = [":userId" => $userId];
	
    // get event from events table - Paid Events
    $query = "SELECT * FROM VIT_EVENT
                INNER JOIN VIT_USER 
                ON VIT_USER.USERID = VIT_EVENT.USERID
                WHERE VIT_EVENT.USERID = :userId
                ORDER BY EVENTSTART DESC";


    if ( isset($_POST["switch"])) {

        $eventType = $_POST['switch'];
        
        if ($eventType == 1) {

            // get event from events table - Free Events
            $query = "SELECT * FROM VIT_EVENT
                        INNER JOIN VIT_USER 
                        ON VIT_USER.USERID = VIT_EVENT.USERID
                        WHERE VIT_EVENT.USERID = :userId 
                        AND VIT_EVENT.EVENTPAID = 0
                        ORDER BY EVENTSTART DESC";

        } elseif ($eventType == 2) {

            // get event from events table - Paid Events
            $query = "SELECT * FROM VIT_EVENT
                        INNER JOIN VIT_USER 
                        ON VIT_USER.USERID = VIT_EVENT.USERID
                        WHERE VIT_EVENT.USERID = :userId 
                        AND VIT_EVENT.EVENTPAID = 1
                        ORDER BY EVENTSTART DESC" ;
                
        }
    }
	
	 $db->executeMySQL($query, $params);
	 
    if($db->rowCount() > 0){
	    $db->echoFull("Event");
	} else {
        $db->echoSuccess();
        $db->response["success"] = 0;
    }

} else {
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}
?>