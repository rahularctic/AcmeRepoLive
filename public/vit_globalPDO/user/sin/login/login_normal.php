<?php
/*
 * Following code will update a user's profile page information
 */
 
$basedir = realpath(__DIR__);
include_once($basedir . '/../../../libs/CRUD.php');
include_once($basedir . '/Image_S3.php');
//include_once($basedir . '/../../../gcm/gcm.php');
require ($basedir . '/../libs/password.php');

$db = new CRUD();
//$gcm = new GCM();

$checkInterest = true;

// check for required fields
if (isset($_POST["USERNAME"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["USERGENDER"]) && isset($_POST["DOB"]) && isset($_POST["gcm_regId"])) { // CHECK IF THE USER POSTED TO CREATE
	
	 	$hash = md5( rand(0,1000) );
	 	
	 	$userName = $_POST['USERNAME'];
		$userEmail = $_POST['email'];
		$password = $_POST['password'];
		$userGender = $_POST['USERGENDER'];
		$userDob = $_POST['DOB'];
		$gcm_regId = $_POST['gcm_regId'];

		$passE = password_hash($password, PASSWORD_DEFAULT, array("cost" => 10));

		$userParams = 	[
						":userEmail" => $userEmail
						];

		// query to check whether the user already exist or not 
		$userCheck = "SELECT * FROM VIT_USER WHERE email = :userEmail";

		$db->executeMySQL($userCheck, $userParams);

		
		if($db->rowCount() > 0){
			
			$db->response["success"] = 2;
			$db->echoSuccess();

		} else {

		// in the case that the user doesn't exist , we create a  new record
			$insertParams =	[
							":userEmail" => $userEmail,
							":userName" => $userName,
							":userGender" => $userGender,
							":password" => $passE,
							":DOB" => $userDob
							];
	
		
			$insert = "	INSERT INTO VIT_USER(USERNAME, password, USERGENDER, email, DOB) 
						VALUES(:userName, :password, :userGender, :userEmail, :DOB)";

			$db->executeMySQL($insert, $insertParams);
			
			if($db->isInserted()) {

				$userId = $db->isInserted();

                //GET DEFAULT IMAGE
                $default_img = file_get_contents(awsBucketURL."/img/user/default.jpeg");

                //Generate the path for the image
                $imagePath = "img/user/".$userId."/";
                $imageName =  time().rand(111, 999).".jpeg";

                $params = [
                    ":imageName" => $imageName,
                    ":userId" => $userId
                ];

                if(uploadUserImgSN($default_img,$imagePath.$imageName)){
                    $updateUserImage = "UPDATE VIT_USER SET USERIMAGE = :imageName WHERE USERID = :userId";
                    $db->executeMySQL($updateUserImage, $params);
                }

				$insertHashParams =	[
									":userId" => $userId,
									":hash" => $hash
									];

				$insertHash = "	INSERT INTO VIT_USERVERIFY(USERID, HASH)
								VALUES(:userId, :hash)";

				$db->executeMySQL($insertHash, $insertHashParams);

				if($db->rowCount() > 0){

					$url = BASEURL . "/user/sin/email/email_send_one.php";
					$data = [
							"hash" => $hash,
							"email" => $userEmail,
							"name" => $userName,
							"password" => $password
					];

					$ch=curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

					$output=curl_exec($ch);
					curl_close($ch);

					$db->response["success"] = 1;
					$db->response["USERID"] = $userId;
					$db->echoSuccess();

					exit;


				} else {

					$db->response["success"] = 0;
					$db->echoSuccess();

					exit;
				}


			} else {
				$db->response["success"] = 0;
				$db->echoSuccess();
	   			exit;
			}


//			// GCM SHTUFF
//			// --------------------------------------------------------------------------------
//			// in case the user doesn't exist , we create a  new user
//			$registatoin_ids = array($gcm_regId);
//			//get Notification key from google server
//			$Notif_Key = "";
//			$Notif_Key = $gcm->get_notification_key($registatoin_ids,$userEmail,$userId);
//			$message = "Got Notification key from google = ".$Notif_Key;
//
//			$updateNKParams = 	[
//								"Notif_Key" => $Notif_Key,
//								":userEmail" => $userEmail
//								];
//
//			//UPDATE ADD NOTIF KEY
//			$update = "	UPDATE VIT_USER
//						SET USERNOTIFKEY = :Notif_Key
//						WHERE email = :userEmail";
//
//			$db->executeMySQL($updateNK, $updateNKParams);
//
//
//			$insertHashParams =	[
//								":userId" => $userId,
//								":hash" => $hash
//								];
//
//			$insertHash = "	INSERT INTO VIT_USERVERIFY(USERID, HASH)
//							VALUES(:userId, :hash)";
//
//			$db->executeMySQL($insertHash, $insertHashParams);

//			if($db->rowCount() > 0){
//
//
//
//			} else {
//
//				$db->response["success"] = 0;
//				$db->echoSuccess();
//			}
		}
 		
} elseif (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['gcm_regId'])) { // CHECK IF THE USER POSTED TO LOGIN

	$userEmail = $_POST['email'];
	$password = $_POST['password'];
	$gcm_regId = $_POST['gcm_regId'];

	$checkInterestsParams = [
							":userEmail" => $userEmail
							];

	$checkInterests = "	SELECT * 
				       	FROM VIT_USER
				       	INNER JOIN VIT_USER_EXTRA 
				       	ON VIT_USER.USERID = VIT_USER_EXTRA.USERID
				       	WHERE email = :userEmail";

   	$db->executeMySQL($checkInterests, $checkInterestsParams);
	
	// if user has interest, they have already done the interest process
	// this is not first login (false)
	if($db->rowCount() > 0){
		$checkInterest = false;
	}

	
	// query to check whether the user already exist or not 
	$userCheck = "	SELECT * 
					FROM VIT_USER 
					WHERE email = :userEmail";

	$db->executeMySQL($userCheck, $checkInterestsParams);			
	
	// if user exists
	if($db->rowCount() > 0 ) {
		
		$user = $db->fetchObj();
		$userName = $user->USERNAME;

		// // GCM SHTUFF
		// // --------------------------------------------------------------------------------
		// $NotifKey = "";
		// $NotifKey = $user->USERNOTIFKEY;
		// $userID = $user->USERID;
		// $registatoin_ids = array($gcm_regId);				
		// $result = $gcm->add_registration_ID($registatoin_ids,$NotifKey,$userEmail,$userID);

		// // if you dont have a notif id, create one
		// if(empty($result)) {
		
		// 	// generate a new notification key for the user , in case the user doesn't have one,
		// 	$Notif_Key = $gcm->get_notification_key($registatoin_ids,$userEmail,$userID);
			
		// 	if(isset($Notif_Key)) {
			
		// 	$updateNKParams =	[
		// 						":Notif_Key" => $Notif_Key,
		// 						":userID" => $userID
		// 						];

		// 	$updateNK = "UPDATE VIT_USER SET USERNOTIFKEY = :Notif_Key WHERE USERID = :userID";

		// 	$db->executeMySQL($updateNK, $updateNKParams);
					
		// 		if (!($db->rowCount() > 0)) {
		// 			// failed to insert row
		// 			$db->response["success"] = 5;
		// 			$db->echoSuccess();
		// 			exit;
		// 		}	
		// 	}	
		// }
	

		// CHECK IF PASSWORDS MATCH
		// ----------------------------------------------
		if(password_verify($password, $user->password)) {
			
			$ACTIVE = intval($user->ACTIVE);

			$db->response["success"] = $ACTIVE;
			$db->response["USERID"] = $user->USERID;
			$db->response["email"] = $user->email;
			$db->response["USERNAME"] = $user->USERNAME;
			$db->response["fL"] = $checkInterest;
			$db->echoSuccess();
		
		} else {
			$db->response["success"] = 2;
			$db->response["message"] = "password Doesnt Match";   
			$db->echoSuccess();
		}
      
	} else {
		$db->response["success"] = 2;
		$db->response["message"] = "User doesnt exist";   
		$db->echoSuccess();
	}
	
} else {
	$db->response["success"] = 3;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();
  	
	exit;
}
?>