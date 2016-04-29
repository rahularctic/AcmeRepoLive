<?php
/*
 * Following code will update a user's profile page information
 */

// array for JSON response
$response = array();

 //=================================
 // 			INCLUDE
 //=================================
 
$basedir = realpath(__DIR__);

// include db connect class
require_once($basedir . '/../../config/db_connect.php');
require 'password.php';

// include GCM class
include_once($basedir . '/../../gcm/gcm.php');

// connecting to db
$db = new DB_CONNECT();

// create new instance of gcm class
$gcm = new GCM();

// minor fix for description characters
mysql_set_charset("utf8");

// check for required fields
if (isset($_POST['userName']) && isset($_POST['userEmail']) && isset($_POST['userPassword']) && isset($_POST['userGender']) && isset($_POST['userDob']) && isset($_POST['gcm_regId'])) { // CHECK IF THE USER POSTED TO CREATE
	
		//=================================
	 	//			VARIABLES
	 	//=================================
	 	$hash = md5( rand(0,1000) );
	 	
	 	$name = mysql_escape_string($_POST['userName']);
		$email = mysql_escape_string($_POST['userEmail']);
		$password = mysql_escape_string($_POST['userPassword']);
		$gender = mysql_escape_string($_POST['userGender']);
		$dob = mysql_escape_string($_POST['userDob']);
		$gcm_regId = $_POST['gcm_regId'];

		$passE = password_hash($password, PASSWORD_DEFAULT, array("cost" => 10));

		// query to check whether the user already exist or not 
		$query = mysql_query("SELECT * FROM VIT_USER WHERE email = '$email'");
		
		if( mysql_num_rows($query) > 0 ){
			
			$response["success"] = 2;     
			
			echo json_encode($response);
	      
		}else{
	
		
			$insert = mysql_query("INSERT INTO VIT_USER(USERNAME, password, USERGENDER, email, DOB) VALUES(
					'". mysql_escape_string($name) ."', 
					'". mysql_escape_string($passE) ."',
					'". mysql_escape_string($gender) ."', 
					'". mysql_escape_string($email) ."',
					'". mysql_escape_string($dob) ."') ") or die(mysql_error());
					
			$userId = mysql_insert_id();


			// GCM SHTUFF
			// --------------------------------------------------------------------------------
			// in case the user doesn't exist , we create a  new user
			$registatoin_ids = array($gcm_regId);
			//get Notification key from google server
			$Notif_Key = "";
			$Notif_Key = $gcm->get_notification_key($registatoin_ids,$userEmail,$userId);
			$message = "Got Notification key from google = ".$Notif_Key;

			
			//UPDATE ADD NOTIF KEY
			$update = mysql_query("UPDATE VIT_USER SET USERNOTIFKEY = '$Notif_Key' WHERE email = '$email'");
			
			$insert1 = mysql_query("INSERT INTO VIT_USERVERIFY(USERID, HASH) VALUES(
					'$userId',
					'". mysql_escape_string($hash) ."') ") or die(mysql_error());
	
			
				if(mysql_affected_rows() > 0){
					
				// start PHP #2
			    	$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "http://www.vitee.net/vit/user/sin/send_email.php" );
					curl_setopt($ch, CURLOPT_POSTFIELDS, "hash=$hash && email=$email && name=$name && password=$password");
					
					curl_setopt($ch, CURLOPT_USERAGENT, 'api');
					curl_setopt($ch, CURLOPT_TIMEOUT, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
					curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
					curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10); 
					curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
					
					$output = curl_exec($ch);
					curl_close($ch);
					echo $output;
					
					$response["success"] = 1;
					$response["userId"] = $userId;
					$response["userName"] = $name;
					$response["userEmail"] = $userEmail;
					
					// echoing JSON response
				  	echo json_encode($response);
				  	
					exit;
				
				}else{
					
					$response["success"] = 0;      
					
					echo json_encode($response);
				}
		}
 		
} elseif (isset($_POST['userEmail']) && isset($_POST['userPassword']) && isset($_POST['gcm_regId'])) { // CHECK IF THE USER POSTED TO LOGIN

	//=================================
 	//		VARIABLES
 	//=================================
	$email = $_POST['userEmail'];
	$password = $_POST['userPassword'];
	$gcm_regId = $_POST['gcm_regId'];

	
	// query to check whether the user already exist or not 
	$query = mysql_query("SELECT * 
				FROM VIT_USER 
				WHERE email = '$email'");				
	
	// if user exists
	if( mysql_num_rows($query) > 0 ){
		
		$row = mysql_fetch_array($query);



		// GCM SHTUFF
		// --------------------------------------------------------------------------------
		$NotifKey = "";
		$NotifKey = $row['USERNOTIFKEY'];
		$userID = $row['USERID'];
		$registatoin_ids = array($gcm_regId);				
		$result = $gcm->add_registration_ID($registatoin_ids,$NotifKey,$userEmail,$userID);

		// if you dont have a notif id, create one
		if(empty($result)){
		
			// generate a new notification key for the user , in case the user doesn't have one,
			$Notif_Key = $gcm->get_notification_key($registatoin_ids,$userEmail,$userID);
			
			if(isset($Notif_Key)){
			
			// update the old notification key by the new one
			$update = mysql_query("UPDATE VIT_USER SET USERNOTIFKEY = '$Notif_Key' WHERE USERID = '$userID'");
					
				if (!$update) {
				
					// failed to insert row
					$response["success"] = 5;
					//$response["message"] = $result;
					
					// echoing JSON response
					echo json_encode($response);
					exit;
				}	
				
			}
			
				
			
			
			
			
			
		}
	

		// CHECK IF PASSWORDS MATCH
		// ----------------------------------------------
		if(password_verify($password, $row['password'])){
			
			$response["success"] = $row['ACTIVE'];
			$response["userId"] = $row["USERID"];
			$response["userName"] = $row["USERNAME"];
			$response["userEmail"] = $userEmail;
			
			echo json_encode($response);
		
		}else{
		
			$response["success"] = 2;   
			echo json_encode($response);
		}
      
	  
	  // user doesn't exist
	}else{
		
		$response["success"] = 2;   
		echo json_encode($response);
	}
	
	// incorrect post vars
} else {
	

	$response["success"] = 3;
	
	// echoing JSON response
  	echo json_encode($response);
  	
	exit;
}
?>