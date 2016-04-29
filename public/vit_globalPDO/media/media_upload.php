<?php

/*
 * Following code will upload an image for a given event
 */
 
 // ============================================================
 // 						INCLUDE
 // ============================================================

$basedir = realpath(__DIR__);

// include config files
include($basedir . '/../libs/CRUD.php');
require_once($basedir . '/Image_S3.php');


// instanciate Crud class - DB connection
$db = new CRUD();


// array for JSON response
$response = array();



// check for post data

if (isset($_POST["EVENTID"]) && isset($_FILES["uploaded_file"])) {
 // ============================================================
 // 						VARIABLES
 // ============================================================


	//GET POST VARIABLES
	$eventId = $_POST['EVENTID'];

	// Genarate File Name and Path for the image
	$imageName =   time().rand(111, 999).".jpeg";
	$imagePath = 'img/event/'.$eventId.'/';

	$img = $_FILES["uploaded_file"]["tmp_name"];


	//CONVERT IMAGE TO JPEG FORMAT
	if (($img_info = getimagesize($img)) === FALSE)
		die("Image not found or not an image");

	switch ($img_info[2]) {
		case IMAGETYPE_GIF  : $src = imagecreatefromgif($img);  break;
		case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($img); break;
		case IMAGETYPE_PNG  : $src = imagecreatefrompng($img);  break;
		default : die("Unknown filetype");
	}

	// get the width and height
	$height = imagesy($src);
	$width = imagesx($src);


    // upload event image using
	if(uploadEventImg($src,$imagePath.$imageName,0,$width,$height)
		&& uploadEventImg($src,$imagePath.'header/'.$imageName,1080,$width,$height)
		&& uploadEventImg($src,$imagePath.'thumbnails/'.$imageName,300,$width,$height)
	){

		// SWITCH BOOLEAN - Indicates if the upload image is the main image | 1 -> main image , 0 -> gallery image
		$response["SWITCH"] = 0;

		// get the name of the main image
		$params = 	[
			":eventId" => $eventId
		];

		$select_query = "SELECT EVENTIMAGE FROM VIT_EVENT WHERE EVENTID = :eventId";

		$db->executeMySQL($select_query, $params);

		$result = $db->rowFetch();

		if($db->rowCount() > 0){

		$mainImage = $result['EVENTIMAGE'];

			// set the uploaded image as the main Image
			if($mainImage == null || $mainImage == ''){

				$params = 	[
					":eventId" => $eventId,
					":imageName" => $imageName
				];

				$update_query = "UPDATE VIT_EVENT
					Set EVENTIMAGE = :imageName
					WHERE EVENTID = :eventId";

				$db->executeMySQL($update_query, $params);
				$response["SWITCH"] = 1;
			}
		}


		// success
		$response["success"] = 1;
		$response["EVENTIMAGE"] = $imageName;
		$response["message"] = " File has been uploaded";
		// echoing JSON response
		echo json_encode($response);



	}else{

		// error uploading image
		$response["success"] = 0;
		$response["message"] = "error uploading image";

		// echo no users JSON
		echo json_encode($response);
	}

} else {
	// error uploading image
    $response["success"] = 0;
	$response["message"] = "error test";

    // echo no users JSON
    echo json_encode($response);
}


?>