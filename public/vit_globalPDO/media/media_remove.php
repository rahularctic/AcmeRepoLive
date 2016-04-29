<?php

/*
 * Following code will remove an image from a given event
 */
 
 // ============================================================
 // 						INCLUDE
 // ============================================================

set_time_limit(5000);

$basedir = realpath(__DIR__);

include($basedir . '/../libs/CRUD.php');
require_once($basedir . '/Image_S3.php');


// instanciate Crud class - DB connection
$db = new CRUD();

// array for JSON response
$response = array();
 
// check for post data
if (isset($_POST["EVENTID"]) && isset($_POST['EVENTIMAGE'])) {

 // ============================================================
 // 						VARIABLES


    //get teh post variables
	$eventId = $_POST['EVENTID'];
	$imageName = $_POST['EVENTIMAGE'];

	// delete images from s3 bucket
	if(	deleteEventImage($eventId,$imageName) ){


		// get the name of the main image
		$params = 	[
			":eventId" => $eventId,
			":eventImage" => $imageName

		];

		$select_query = "SELECT EVENTIMAGE FROM VIT_EVENT WHERE EVENTID = :eventId AND EVENTIMAGE = :eventImage";

		$db->executeMySQL($select_query, $params);

		$result = $db->rowFetch();

		// if it s the main image - replace it by another image if exist
		if($db->rowCount() > 0){

			$images  = getEventHeaderImages($eventId);


			$eventImageName = null;

				if(count($images) > 0){

					$eventImageName = $images[0];
				}

			$params = 	[
				":eventId" => $eventId,
				":eventImage" => $eventImageName

			];

			$update_query = "UPDATE VIT_EVENT
					Set EVENTIMAGE = :eventImage
					WHERE EVENTID = :eventId";

			$db->executeMySQL($update_query, $params);
			$response['EVENTHEADER'] = $eventImageName;

		}


		// image removed
		$response["success"] = 1;

		// echoing JSON response
		echo json_encode($response);
	}
	else{

		// error while removing image
		$response["success"] = 0;

		// echo no users JSON
		echo json_encode($response);
	}




} else {

	// no post vars
	$response["success"] = 0;

	// echo no users JSON
	echo json_encode($response);

}

?>