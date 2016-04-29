<?php
 
/*
 * Following code will delete an new event
 * An event is determined by eventId
 * The event row will be deleted from the table
 * The event directory will be deleted on the image file system
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../../libs/CRUD.php');
include_once($basedir . '/../../../gcm/gcm.php');
$db = new CRUD();
$gcm = new GCM();

if (isset($_POST['EVENTID'])) {

    $eventId = $_POST['EVENTID'];
    $params =   [
                ":eventId" => $eventId
                ];
    $name_result = "    SELECT EVENTNAME
                        FROM VIT_EVENT
                        WHERE EVENTID = :eventId";
    $db->executeMySQL($name_result, $params);

    if($db->rowCount() > 0){
        $event = $db->fetchObj();
        $eventName = $event->EVENTNAME;
    }

    $query = "   SELECT  VIT_USER.USERNOTIFKEY FROM VIT_USERATTENDING
                 INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_USERATTENDING.USERID
                 WHERE VIT_USERATTENDING.EVENTID = :eventId  AND
                 VIT_USER.USERNOTIFKEY IS NOT NULL AND
                 VIT_USER.USERNOTIFKEY <> '' ";

    $db->executeMySQL($query, $params);
    if($db->rowCount() > 0){
        $result_query = $db->fetchAll();
    }


    $result = "DELETE FROM VIT_EVENT WHERE EVENTID = :eventId";
    $db->executeMySQL($result, $params);
    
    
    // check if row deleted or not
    if ($db->rowCount() > 0) {
       $message = array("message" => $eventName, "activity"=>"delete_event" , "eventId" => $eventId);
        
        if(!empty($result_query)){
		    $gcm->send_notification($result_query['USERNOTIFKEY'],$message);
	    }

        $db->response["success"] = true;
        $db->response["message"] = "Event successfully deleted";
        $db->echoSuccess();
    } else {
        $db->response["success"] = false;
    	$db->response["message"] = "Oops, an error occurred (1)";
        $db->echoSuccess();
    }
} else {
    $db->response["success"] = false;
    $db->response["message"] = "Oops, an error occurred (2)";
    $db->echoSuccess();
}

?>