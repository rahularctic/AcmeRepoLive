<?php
 
/*
 * Following code will get single event details
 * An event is identified by event id (eventId)
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["EVENTID"])) {

    $eventId = $_POST['EVENTID'];
    $params =    [
                ":eventId" => $eventId
                ];

    $result = "SELECT * FROM VIT_EVENT WHERE EVENTID = :eventId";
    $db->executeMySQL($result, $params);
    if($db->rowCount() > 0){
        $db->echoFull("Event");
    } else {
        $db->response["success"] = 0;
        $db->echoSuccess();
    }

} else {
    // required field is missing
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}
?>