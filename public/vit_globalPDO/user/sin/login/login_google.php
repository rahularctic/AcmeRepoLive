<?php

$basedir = realpath(__DIR__);
require_once($basedir . '/../../../libs/CRUD.php');
include_once($basedir . '/Image_S3.php');
//include_once($basedir . '/../../../gcm/gcm.php');
$db = new CRUD();
//$gcm = new GCM();

$checkInterest = true;

// check for required fields
if (isset($_POST['email']) && isset($_POST['USERNAME']) && isset($_POST['gcm_regId']) && isset($_POST['DOB']) && isset($_POST['USERGENDER'] )) {

	$userEmail = $_POST['email'];
	$userName = $_POST['USERNAME'];
	$gcm_regId = $_POST['gcm_regId'];
	$userDob = $_POST['DOB'];
	$userGender = $_POST['USERGENDER'];
    $userGoogleID = $_POST['USERGOOGLEID'];

	$userCheckParams = 	[
						":userEmail" => $userEmail
						];

	$checkInterests = "	SELECT * 
				       	FROM VIT_USER
				       	INNER JOIN VIT_USER_EXTRA 
				       	ON VIT_USER.USERID = VIT_USER_EXTRA.USERID
				       	WHERE email = :userEmail";

   	$db->executeMySQL($checkInterests, $userCheckParams);
	
	// if user has interest, they have already done the interest process
	// this is not first login (false)
	if($db->rowCount() > 0){
		$checkInterest = false;
	}
	
	// query to check whether the user already exist or not 
	$userCheck = "	SELECT * 
					FROM VIT_USER 
					WHERE email = :userEmail";

	$db->executeMySQL($userCheck, $userCheckParams);
     
	if ($db->rowCount() > 0) {
		// USER ALREADY EXISTS
		$userResult = $db->fetchObj();
		$userID = $userResult->USERID;


		if ($userResult->ACTIVE == 0) {
			$updateActive = "UPDATE VIT_USER SET ACTIVE = '1'";
			$db->executeMySQL($updateActive);

			if($db->rowCount() > 0) {

				$db->response["success"] = 1;
				$db->response["USERID"] = $userID;
				$db->response["fL"] = $checkInterest;
				$db->echoSuccess();
			} else {
				$db->response["success"] = 0;
				$db->echoSuccess();
			}
		} else {
			$db->response["success"] = 1;
			$db->response["USERID"] = $userID;
			$db->response["fL"] = $checkInterest;
			$db->echoSuccess();
		}
		
//		$NotifKey = "";
//		$NotifKey = $userResult->USERNOTIFKEY;
//		$userID = $userResult->USERID;
//
//		$registatoin_ids = array($gcm_regId);
//
//		$result = $gcm->add_registration_ID($registatoin_ids,$NotifKey,$userEmail,$userID);
//
//		// if you dont have a notif id, create one
//		if(empty($result)) {
//
//			// generate a new notification key for the user , in case the user doesn't have one,
//			$Notif_Key = $gcm->get_notification_key($registatoin_ids,$userEmail,$userID);
//
//			$updateNKParams = 	[
//								":Notif_Key" => $Notif_Key,
//								":userEmail" => $userEmail
//								];
//
//			// update the old notification key by the new one
//			$updateNK = "UPDATE VIT_USER SET USERNOTIFKEY = :Notif_Key WHERE email = :userEmail ";
//
//			$db->executeMySQL($updateNK, $updateNKParams);
//
//			// check if row inserted or not
//			if ($db->rowCount > 0) {
//
//				$db->response["USERID"] = $userID;
//				$db->response["fL"] = $checkInterest;
//				$db->echoSuccess();
//
//			} else {
//
//				// failed to insert row
//				$db->response["success"] = 0;
//				$db->response["USERID"] = $userID;
//				$db->echoSuccess();
//			}
//
//			$result = $Notif_Key;
	//		} else {
	//				// successfully inserted into database
	//				$db->response["success"] = 1;
	//				$db->response["USERID"] = $userID;
	//				$db->response["fL"] = $checkInterest;
	//				$db->echoSuccess();
	//		}
		
	} else {	

		$insertParams =	[
						":userEmail" => $userEmail,
						":userName" => $userName,
						":userGender" => $userGender,
						":userDob" => $userDob
						];
		
		$insert = "	INSERT INTO VIT_USER(email, USERNAME, USERGENDER, DOB, ACTIVE) 
					VALUES(:userEmail, :userName, :userGender, :userDob, '1')" ;
	    
	    $db->executeMySQL($insert, $insertParams);
    	
    	if($db->isInserted()) {
    		//$insert = $db->fetchObj();
    		$userId = $db->isInserted();

    		$rowCount = $db->rowCount();
    	} else {
    		$db->echoSuccess();
    		exit;
    	}


            if(isset($userGoogleID)){
            //GET IMAGE FROM GOOGLE
            $request =  'https://www.googleapis.com/plus/v1/people/'.$userGoogleID.'?fields=image&key='.GOOGLE_API_KEY;
                $user_image =  json_decode(file_get_contents($request),true); ;
                //change image size from 50 to 300
                $image =  $user_image['image']['url'];
                $image = substr_replace("$image","300",-2);

            // ----------  UPLOAD IMAGE TO S3 BUCKET   -----------

            //convert image to a string resource
            $img = file_get_contents($image);

            //generate the path for the image
            $imagePath = "img/user/".$userId."/";
            $imageName =  time().rand(111, 999).".jpeg";

            $params = [
                ":imageName" => $imageName,
                ":userId" => $userId
            ];
                if(isset($img)) {

                    if(uploadUserImgSN($img,$imagePath.$imageName)){
                        $updateUserImage = "UPDATE VIT_USER SET USERIMAGE = :imageName WHERE USERID = :userId";
                        $db->executeMySQL($updateUserImage, $params);
                    }

                }else{

                    $default_img = file_get_contents(awsBucketURL."/img/user/default.jpeg");
                    if(uploadUserImgSN($default_img,$imagePath.$imageName)){
                        $updateUserImage = "UPDATE VIT_USER SET USERIMAGE = :imageName WHERE USERID = :userId";
                        $db->executeMySQL($updateUserImage, $params);
                    }
                }

            }

        $db->response["success"] = 1;
        $db->response["USERID"] = $userId;
        $db->response["fL"] = $checkInterest;
        $db->echoSuccess();
		    	
/*		// in case the user doesn't exist , we create a  new user
		$registatoin_ids = array($gcm_regId);
		
		//get Notification key from google server
		$Notif_Key = "";
		$Notif_Key = $gcm->get_notification_key($registatoin_ids,$userEmail,$userId);
		$message = "Got Notification key from google = ".$Notif_Key;

		$updateNkParams = 	[
							":Notif_Key" => $Notif_Key,
							":userId" => $userId
							];
		
		$updateNk = "UPDATE VIT_USER SET USERNOTIFKEY = :Notif_Key WHERE USERID = :userId";
		
		$db->executeMySQL($updateNk, $updateNkParams);

			
			// check if row inserted or not
			if ($rowCount > 0) {
				$db->response["success"] = 1;
		        $db->response["USERID"] = $userId;
		        $db->response["fL"] = $checkInterest; 
				$db->echoSuccess();
			} else {
				$db->response["success"] = 0;
				$db->echoSuccess();
			}


*/
    }

	
} else {
    $db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred"; 			
	$db->echoSuccess();
}

?>