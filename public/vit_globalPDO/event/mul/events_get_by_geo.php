<?php

/*
 * Following code will find events based on location 
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();
  
// check for post data
if (isset($_POST["userLat"]) && isset($_POST['userLng'])  && isset($_POST['searchRadius'])) {

	$latitude = $_POST['userLat'];
	$longitude = $_POST['userLng'];
	$searchRadius = $_POST['searchRadius'];
  
	$params = [":latitude" => $latitude, ":longitude" => $longitude, ":searchRadius" => $searchRadius];
 
	// get all events from events table
	$query =  "SELECT *, ( 
					6371 * acos( 
						  cos( radians(:latitude ) ) 
						* cos( radians( EVENTLATITUDE ) ) 
						* cos( radians( EVENTLONGITUDE ) - radians( :longitude ) ) 
						+ sin( radians(:latitude ) ) 
						* sin( radians( EVENTLATITUDE ) ) 
						) 
					) 
					AS distance
					FROM VIT_EVENT
					INNER JOIN VIT_USER
					ON VIT_EVENT.USERID = VIT_USER.USERID
					WHERE EVENTEND > CURDATE()
					HAVING distance < :searchRadius					
					ORDER BY distance
					LIMIT 0, 20";
	
	 $db->executeMySQL($query, $params);
	 
	 if($db->rowCount() > 0){	
		
	 $db->echoFull("Event");
		
	}else{	
	  $db->response["success"] = 0;
	  $db->echoSuccess();
	}

} else {
    $db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}
?>