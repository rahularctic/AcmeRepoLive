<?php

$basedir = realpath(__DIR__);
require_once($basedir . '/../../../libs/CRUD.php');
//include_once($basedir . '/../../../gcm/gcm.php');
$db = new CRUD();
//$gcm = new GCM();

// check for required fields
if ( isset($_POST['USERID'])  && isset($_POST['gcm_regId'])) {

	$userId = $_POST['USERID'];
	$gcm_regId = $_POST['gcm_regId'];

	$params = 	[
				":userId" => $userId
				];	

	$query = "	SELECT * 
				FROM VIT_USER 
				WHERE USERID = :userId";

	$db->executeMySQL($query, $params);

	if($db->rowCount() > 0){
		$user = $db->fetchObj();
		$userEmail = $user->email;
		$NotifKey = $user->USERNOTIFKEY;
	} else {
		$db->echoSuccess();
		exit;
	}

	$NotifKeyDB = $NotifKey;

	$registatoin_ids = array($gcm_regId);

	$Notif_Key = $gcm->remove_registration_ID($registatoin_ids,$NotifKey,$userEmail,$userID);

	$file = 'notification_key.txt';

		// The new person to add to the file
	$data = "\n Logout From Google  ,  UserEmail: ".$userEmail ."  gcm ID :".$gcm_regId." Notif key from db = ".$NotifKeyDB ."Notif key from response :".$Notif_Key;

	file_put_contents($file, $data, FILE_APPEND | LOCK_EX);


	$db->echoSuccess();

} else {

$file = 'notification_key.txt';

	// The new person to add to the file
$data = "\n Logout From Google  didn't work";

file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

}


?>