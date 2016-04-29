<?php

/*
 * Following code will update a user's profile page information
 */

$basedir = realpath(__DIR__);

//require_once($basedir . '/config.php');
require_once  ($basedir . '/../../../libs/CRUD.php');
require_once  ($basedir . '/Image_S3.php');

$db = new CRUD();

// check for required fields
if (isset($_POST['USERID']) && isset($_POST['USERNAME']) && isset($_POST['USERDESCRIPTION'])) {
 
	$userId = $_POST['USERID'];
	$userName = $_POST['USERNAME'];
	$userDescription = $_POST['USERDESCRIPTION'];
	$gender = mysql_escape_string($_POST['USERGENDER']);
	$dob = mysql_escape_string($_POST['DOB']);
	$imageName = null;


	// if an image is uploaded
	if(isset($_FILES["uploaded_file"] )){

		//get the image
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



	
		$imagePath = "img/user/".$userId."/";
		$imageName =  time().rand(111, 999).".jpeg";

		//create jpeg image and upload it to S3 bucket
		if(updateUserImg($src,$imagePath.$imageName,300,$width,$height)){


		}else{

			$db->response["success"] = 2;
			$db->echoSuccess();
			exit;
		}
	}
    	

	if ($imageName != null) {

		$params = 	[
			":userId" => $userId,
			":userName" => $userName,
			":userDescription" => $userDescription,
			":dob" => $dob,
			":gender" => $gender,
			":userImage" => $imageName
		];

		$query = "	UPDATE VIT_USER
				Set USERNAME = :userName, USERDESCRIPTION = :userDescription, DOB = :dob, USERGENDER = :gender, USERIMAGE = :userImage
				WHERE USERID = :userId";

        $db->response["USERIMAGE"] = $imageName;

	} else {

		$params = 	[
			":userId" => $userId,
			":userName" => $userName,
			":userDescription" => $userDescription,
			":dob" => $dob,
			":gender" => $gender
		];
		$query = "	UPDATE VIT_USER
				Set USERNAME = :userName, USERDESCRIPTION = :userDescription, DOB = :dob, USERGENDER = :gender
				WHERE USERID = :userId";
	}


    $db->executeMySQL($query, $params);
    
    if($db->rowCount() > 0) {
    	$db->echoSuccess();
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