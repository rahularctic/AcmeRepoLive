<?php
 
/*
 * Following code will get single event data
 * An event is identified by event id (eventId)
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
include_once($basedir . '/Image_S3.php');



$db = new CRUD();

if(isset($_POST["EVENTID"])){

    $eventId = $_POST['EVENTID'];
	$params = 	[
				":eventId" => $eventId
				];
    $result = "	SELECT *
    			FROM VIT_EVENT
    			INNER JOIN VIT_USER ON VIT_EVENT.USERID = VIT_USER.USERID
    			WHERE VIT_EVENT.EVENTID = :eventId";
    $db->executeMySQL($result, $params);


	
	if($db->rowCount() > 0){



/*		$bucketName ='media-vitee';
		S3::setAuth(awsAccessKey, awsSecretKey);
		$dir = [];
		foreach (new DirectoryIterator("s3://{$bucketName}/img/event/{$eventId}/header") as $b) {
			//ignore folders - take only files
			if(substr($b,-5) == '.jpeg') {
				$dir [] = ''.substr($b,1);
			}
		}
*/
/*		$numOfFiles = 0;
*/
		$db->response["EVENTIMAGENAMES"] = getEventHeaderImages($_POST["EVENTID"]);

        getEventHeaderImages($_POST["EVENTID"]);
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