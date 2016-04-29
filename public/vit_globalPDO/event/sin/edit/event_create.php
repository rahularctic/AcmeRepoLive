<?php
 
/*
 * Following code will create a new event
 * An event is determined by eventId
 * The code will insert all the event details into the row
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../../libs/CRUD.php');
$db = new CRUD();

if 
(isset($_POST['EVENTNAME'])
&& isset($_POST['EVENTDESCRIPTION'])
&& isset($_POST['EVENTSTART'])
&& isset($_POST['EVENTEND'])
&& isset($_POST['EVENTLOCATION'])
&& isset($_POST['EVENTTYPEID'])
&& isset($_POST['EVENTPAID'])
&& isset($_POST['EVENTPRIVACY'])
&& isset($_POST['USERID'])) {

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
	$result = "	INSERT INTO VIT_EVENT(USERID, EVENTNAME,   EVENTDESCRIPTION,    EVENTSTART,    EVENTEND,    EVENTLOCATION,    EVENTLATITUDE,    EVENTLONGITUDE,    EVENTTYPEID,  EVENTPAID,    EVENTPRIVACY)
				VALUES(:userId, :eventName, :eventDescription, :eventStart, :eventEnd, :eventLocation, :eventLatitude, :eventLongitude, :eventType, :eventPaid, :eventPrivacy)";

	$db->executeMySQL($result, $params);

	if($db->isInserted() > 0){
		$eventId = $db->isInserted();
	} else {
		$db->response["success"] = 0;
		$db->echoSuccess();
		exit;
	}
	
	if($eventPaid == true) {
	
		if (isset($_POST['Ticket'])) {
		
			$ticketList = $_POST['Ticket'];
			
			$obj =  json_decode($ticketList, true);
			
			// foreach loop
			foreach ($obj as $ticketObj) {
			
				$ticket =  json_decode($ticketObj, true);
				
				$ticketCuId = 1;
				$ticketTypeName = $ticket['TICKETTYPENAME'];
				$ticketTypeDescription = $ticket['TICKETTYPEDESCRIPTION'];
				$ticketPrice = $ticket['TICKETPRICE'];
				$ticketMin = $ticket['TICKETMIN'];
				$ticketMax = $ticket['TICKETMAX'];
				$ticketStart = $ticket['TICKETSTARTSALES'];
				$ticketEnd = $ticket['TICKETENDSALES'];
				$ticketTotal = $ticket['TICKETQUANTITY'];

				$params1 =	[
							":$ticketCuId" => $ticketCuId,
							":$ticketTypeName" => $ticketTypeName,
							":$ticketTypeDescription" => $ticketTypeDescription,
							":$ticketPrice" => $ticketPrice,
							":$ticketMin" => $ticketMin,
							":$ticketMax" => $ticketMax,
							":$ticketStart" => $ticketStart,
							":$ticketEnd" => $ticketEnd,
							":$ticketTotal" => $ticketTotal
							];
				$query = "	INSERT INTO VIT_TICKETTYPE( TICKETCUID,    EVENTID,    TICKETTYPENAME,    TICKETTYPEDESCRIPTION,    TICKETPRICE,    TICKETMIN,    TICKETMAX,    TICKETSTARTSALES,  TICKETENDSALES,  TICKETTOTAL,    TICKETREMAINING)
							VALUES(:ticketCuId, :eventId, :ticketTypeName, :ticketTypeDescription, :ticketPrice, :ticketMin, :ticketMax, :ticketStart, :ticketEnd, :ticketTotal, :ticketTotal)";

				$db->executeMySQL($query, $params1);

				if($db->isInserted() > 0){
					$ticketId = $db->isInserted();
				} else {
					$db->response["success"] = 0;
					$db->echoSuccess();
					exit;
				}
			}	
		}
	}

	$db->response["success"] = true;
	$db->response["eventId"] = $eventId;
	$db->echoSuccess();
} else {
	$db->response["success"] = false;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();
}  

?>