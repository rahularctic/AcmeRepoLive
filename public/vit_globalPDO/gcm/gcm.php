<?php

/* 
* This is Gcm, class contains all functionalities related to push notifications
*
*/


$basedir = realpath(__DIR__);

include($basedir . '/../config/config.php');
    
class GCM {
 
    //put your code here
    // constructor
    function __construct() {
         
    }
    



    

    public function send_notification($NotifKey,$message) {
        // include config
        include('./../config/config.php');
 
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'data' => $message,
            'to' => $NotifKey
        );
 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
      //  echo $result;
      
      
       $file = 'notification_key.txt';
	// The new person to add to the file
	

	$data = "\n Send Message from GCM.PHP | msg:  ".$message." , Notif Key = ".$NotifKey;

	//file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
    }
	


    public function get_notification_key($registatoin_ids, $userName,$userID) {
		
	// include config
//       include './../config/config.php';

 
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/notification';
        
 	$userName = $userName;
        $fields = array(
			"operation" => "create",
			"notification_key_name" => "v_".$userID,
			"registration_ids" => $registatoin_ids,
        );
 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY, 
	        'project_id : ' . PROJECT_ID,
            'Content-Type: application/json'
        );
		
		
		        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
      
		

	$arr= json_decode($result,true);
	$notification_key = $arr['notification_key'];

	
	
	$file = 'notification_key.txt';
	// The new person to add to the file
	$data = "Create notification key, | USERID = ".$userID." | useremail = '".$userName."' ,notif key =  ".$notification_key." \n GCM ID: ".$registatoin_ids[0]."\n";

	//file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
		
	return $notification_key;
			
	}
	
	
	
	
public function add_registration_ID($registatoin_ids,$NotifKey,$userName,$userID) {
		
    // include config
//  include '../config/config.php

$basedir = realpath(__DIR__);

//include($basedir . '/../config/config.php');
        
 
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/notification';
 
 	//$userName = "vitee_42425";
 	
 	$userName = $userName;
 	
        $fields = array(
			"operation" => "add",
			"notification_key_name" => "v_".$userID,
			"notification_key" => $NotifKey,
			"registration_ids" => $registatoin_ids,
        );
 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY, 
	        'project_id : ' . PROJECT_ID,
            'Content-Type: application/json'
        );
		
		
		        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
      
		

	$arr= json_decode($result,true);
	//$notification_key = $arr['notification_key'];
	//$notification_key = "test";

	
	$file = 'notification_key.txt';
	// The new person to add to the file
	
	if(array_key_exists('notification_key', $arr)){
	
	$arrlength = count($arr);	
	$notification_key = $arr['notification_key'];
	$data = "\n  \n Add A GCM ID TO A Notification key| gcm_id : ". $registatoin_ids[0]." |".$userName."  Add GCM ID : Notif key =  ".$notification_key."\n";
	
	
	}else{
	
	$data = "\n  No Notif Key for this User New once must be created  ";
	$notification_key = "";
	}


	//file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
		
	return $notification_key;
			
	}

	
	public function remove_registration_ID($registatoin_ids,$NotifKey,$userName,$userID) {
		
	// include config
//    include '../config/config.php';

$basedir = realpath(__DIR__);

//include($basedir . '/../config/config.php');
  
 
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/notification';
 
 	//$userName = "vitee_42425";
 	
 	$userName = $userName;
 	
        $fields = array(
			"operation" => "remove",
			"notification_key_name" => "v_".$userID,
			"notification_key" => $NotifKey,
			"registration_ids" => $registatoin_ids,
        );
 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY, 
	        'project_id : ' . PROJECT_ID,
            'Content-Type: application/json'
        );
		
		
		        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
      
		

	$arr= json_decode($result,true);
	$notification_key = $arr['notification_key'];
	//$notification_key = "test";

	
	$file = 'notification_key.txt';
	// The new person to add to the file
	$arrlength = count($arr);
	

/*
	Don't forget to convert gcm id to json file !!!!!!!!!!!!!!!!!!!!!


*/

	       
      $dir = __DIR__ . '../../config/db_connect.php';
	
	$data = "path :"+$dir+" Remove Registration ID : ".$userName." , ".$notification_key."\n";

	//file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
		
	return $notification_key;
			
	}

 
}
 
 
?>