<?php


$basedir = realpath(__DIR__);

// include db connect class
require_once($basedir . '/../../config/db_connect.php');

       
// include GCM class
include_once($basedir . '/../../gcm/gcm.php');

// connecting to db
$db = new DB_CONNECT();

// array for JSON response
$response = array();

// minor fix for description characters
mysql_set_charset("utf8");

// check for required fields
if ( isset($_POST['token'])&& isset($_POST['gcm_regId'])) {


	// create new instance of gcm class
	$gcm = new GCM();

	$token = $_POST['token'];
	$gcm_regId = $_POST['gcm_regId'];
	
	$user_details = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" .$token;
	
	$json = file_get_contents($user_details);
	$obj = json_decode($json);
	$userName = $obj->{'name'};
	$userEmail = $obj->{'email'};
	$userGender = $obj->{'gender'};	
	//$userBirthday = $obj->{'birthday'};
	$user_picture = $obj->{'picture'};	     	
	
		
	// query to check whether the user already exist or not 
	$query = mysql_query("SELECT * FROM VIT_USER WHERE email = '$userEmail'");
	
	if( mysql_num_rows($query) > 0 ){
      
		$row = mysql_fetch_array($query);
		
		if ($row['ACTIVE'] == 0){
			$query = mysql_query("UPDATE VIT_USER SET ACTIVE = '1'");
		}
		
		
		$NotifKey = "";
		$NotifKey = $row['USERNOTIFKEY'];
		$userID = $row['USERID'];
		
		$registatoin_ids = array($gcm_regId);		
		
		$result = $gcm->add_registration_ID($registatoin_ids,$NotifKey,$userEmail,$userID);
		
	   // in case a user doesn't have a notification  key,  create one
		if(empty($result)){
		
			// generate a new notification key for the user , in case the user doesn't have one,
			 
			$Notif_Key = $gcm->get_notification_key($registatoin_ids,$userEmail,$userID);
			
			// update the old notification key by the new one 
			
			$update = mysql_query("UPDATE VIT_USER SET USERNOTIFKEY = '$Notif_Key' WHERE email = '$userEmail' ");
			
			// check if row inserted or not
			if ($update) {
			
				// update successfully 			
				$response["success"] = 1;
				$response["userId"] = $userID;	
				$response["userEmail"] = $userEmail;		
				
				// echoing JSON response
				echo json_encode($response);
			
			}
			else {
			
			// failed to update row
			$response["success"] = 0;
		    $response["message"] = "Oops, an error occurred"; 
				
			// echoing JSON response
			echo json_encode($response);
			}
			 
			
		}else {
				// User has already a valid notification key , 			
				$response["success"] = 1;
				$response["userId"] = $row["USERID"];	
				$response["userEmail"] = $userEmail;	
				
				// echoing JSON response
				echo json_encode($response);
		}
	
	}else{
	  // in case the user doesn't exist , we create a  new record
	
	   	$result = mysql_query("INSERT INTO VIT_USER(email, USERNAME, USERGENDER, DOB, ACTIVE) VALUES('$userEmail','$userName','$userGender', STR_TO_DATE('$userBirthday', '%m/%d/%Y'),'1')");
	   	
	    $userId = mysql_insert_id();
	    	
	    // GENERATE NOTIFCATION KEY FOR GCM NOTIFICATION
	    $registatoin_ids = array($gcm_regId);
		
		//get Notification key from Google server
		
		$Notif_Key = "";
		
		$Notif_Key = $gcm->get_notification_key($registatoin_ids,$userEmail,$userId);
		
	
		
		$update = mysql_query("UPDATE VIT_USER SET USERNOTIFKEY = '$Notif_Key' WHERE USERID = '$userId' ");
	    	
	    	// check if row inserted or not
		if ($update) {
		        // successfully inserted into database & updated
		        $response["success"] = 1;
		        $response["userId"] = $userId;
		        $response["userEmail"] = $userEmail;
		        
		        {
		
				// set directory path
				$dirPath = "/home1/blueharl/public_html/vitee/img/user/";
				
				// create new directory based on user email 
				mkdir($dirPath.$userId);
				
				$usersPicturesPath = $dirPath.$userId."/1.jpeg";
				
				file_put_contents($usersPicturesPath, file_get_contents($user_picture));
			}
			
		      
	    
		} else {
		        // failed to insert row
		        $response["success"] = 0;
		        $response["message"] = "Oops, an error has occurred (!)";
		
		        // echoing JSON response
		        echo json_encode($response);
	    	}
	  
	  
	}//END ELSE USER DOESNT EXIST
 
}// POST VARS ARE MISSING
 else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Oops, a token error has occurred";
 
    // echoing JSON response
    echo json_encode($response);
}


 



?>