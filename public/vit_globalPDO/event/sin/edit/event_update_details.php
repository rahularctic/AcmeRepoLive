<?php
 
/*
 * Following code will update an event
 * An event is determined by eventId
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../../libs/CRUD.php');
include_once($basedir . '/../../../gcm/gcm.php');
$db = new CRUD();
$gcm = new GCM();

if 
(isset($_POST['EVENTID'])
&& isset($_POST['EVENTNAME'])
&& isset($_POST['EVENTDESCRIPTION'])
&& isset($_POST['EVENTSTART'])
&& isset($_POST['EVENTEND'])
&& isset($_POST['EVENTLOCATION'])
&& isset($_POST['EVENTTYPEID'])
&& isset($_POST['EVENTPRIVACY'])
&& isset($_POST['USERID'])){

    $eventName = $_POST['EVENTNAME'];
    $eventDescription = $_POST['EVENTDESCRIPTION'];
    $eventStart = $_POST['EVENTSTART'];
    $eventEnd = $_POST['EVENTEND'];
    $eventLocation = $_POST['EVENTLOCATION'];
    $eventLatitude = $_POST['EVENTLATITUDE'];
    $eventLongitude = $_POST['EVENTLONGITUDE'];
    $eventType = $_POST['EVENTTYPEID'];
    $eventPaid = $_POST['EVENTPAID'];
    $eventPrivacy = $_POST['EVENTPRIVACY'];
    
    $userId = $_POST['USERID'];
    $userName= $_POST['USERNAME'];

    $params =	[
        ":userId" => $userId,
        ":eventName" => $eventName,
        ":eventDescription" => $eventDescription,
        ":eventStart" => $eventStart,
        ":eventEnd" => $eventEnd,
        ":eventLocation" => $eventLocation,
        ":eventLatitude" => $eventLatitude,
        ":eventLongitude" => $eventLongitude,
        ":eventType" => $eventType,
        ":eventPaid" => $eventPaid,
        ":eventPrivacy" => $eventPrivacy
    ];
    $result = " UPDATE VIT_EVENT SET
                EVENTNAME = :eventName,
                EVENTDESCRIPTION = :eventDescription,
                EVENTSTART = :eventStart,
                EVENTEND = :eventEnd,
                EVENTLOCATION = :eventLocation,
                EVENTTYPEID = :eventType,
                EVENTLATITUDE = :eventLatitude,
                EVENTLONGITUDE = :eventLongitude,
                EVENTPRIVACY = :eventPrivacy
				WHERE EVENTID = :eventId";

    $db->executeMySQL($result, $params);
				
    if($db->rowCount() > 0){
        $message = array("message" => "$eventName","activity"=>"event","eventId"=>$eventId, "userId"=>$userId, "userName"=>$userName);

        $params1 = [":eventId" => $eventId];
        $query = "  SELECT  VIT_USER.USERNOTIFKEY FROM VIT_USERATTENDING
                    INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_USERATTENDING.USERID
                    WHERE VIT_USERATTENDING.EVENTID = :eventId  AND
                    VIT_USER.USERNOTIFKEY IS NOT NULL AND
                    VIT_USER.USERNOTIFKEY <> '' ";
        $db->executeMySQL($query, $params);
        if($db->rowCount() > 0){
            $ids = $db->fetchAll();
            $gcm->send_notification($ids['USERNOTIFKEY'],$message);
        }

        $db->response["success"] = true;
        $db->echoSuccess();
    } else {
        $db->response["success"] = false;
        $db->echoSuccess();
    }
    
} else {
    $db->response["success"] = false;
    $db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}
?>