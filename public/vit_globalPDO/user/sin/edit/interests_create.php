<?php
/*
 * Following code will update a user's profile page information
 */
 
$basedir = realpath(__DIR__);
require_once  ($basedir . '/../../../libs/CRUD.php');
$db = new CRUD();


if (isset($_POST['USERID']) && isset($_POST['User']) && isset($_POST['Categories']) ) {

	$userId = $_POST['USERID'];
	$interests = $_POST['Categories'];
	$users = $_POST['User'];
	
	$obj =  json_decode($interests, true);
	$u_obj = json_decode($users, true);
	
	if(count($obj) > 0 && count($u_obj) > 0) {
			
		$db->begin();
		
		$success1 = 1;
		$success2 = 1;
		
		// foreach loop: the wrath of the foreach
		foreach ($obj as $eventTypeId) {

			$params = 	[
						":userId" => $userId,
						":eventTypeId" => $eventTypeId,
						];			
			$getInterests = "	SELECT *
								FROM VIT_USER_EXTRA
								WHERE USERID = :userId
								AND INTERESTS = :eventTypeId";
			$db->executeMySQL($getInterests, $params);
			if($db->rowCount() > 0){
				continue;
			}
			
			$insertInterest = "	INSERT INTO VIT_USER_EXTRA(USERID, INTERESTS) 
								VALUES (:userId, :eventTypeId) ";
			$db->executeMySQL($insertInterest, $params);			
			if(!$db->rowCount() > 0){
				$success1 = 0;
				break;
			}
		} // Interest Foreach
	
		// foreach loop: revenge of the loop king
		foreach ($u_obj as $f_userId) {

			$params1 = 	[
						":userId" => $userId,
						":f_userId" => $f_userId
						];
			$getFollow = "	SELECT *
							FROM VIT_FOLLOW
							WHERE USERID = :userId
							AND F_USERID = :f_userId";
			$db->executeMySQL($getFollow, $params1);
			if($db->rowCount() > 0){
				continue;
			}
			
			$insertFollow = "	INSERT INTO VIT_FOLLOW(USERID, F_USERID) 
								VALUES    (:userId, :f_userId) ";
			$db->executeMySQL($insertFollow, $params1);
			if(!$db->rowCount() > 0){				
				$success2 = 0;
				break;
			}
		} // Follow Foreach
		
		$msg = "Error: ";
		if($success1 == 0){
			$msg = $msg."interest, ";
		}
		if($success2 == 0){
			$msg = $msg."follow";		
		}
		
		
		
		if($success1 == 1 && $success2 == 1 )	 {

			$db->commit();
			$db->response["success"] = 1;
			$db->response["message"] = "Success";
			$db->echoSuccess();
			exit;

		} else {

			$db->rollback();
			$db->response["success"] = 0;
			$db->response["message"] = $msg;
			$db->echoSuccess();
			exit;
			
		}
	} // Finish Count Objects

// Finish Isset
} else { 

	// failed to insert row
	$response["success"] = 0;
	$response["message"] = "Oops, an error occurred";
	$db->echoSuccess();

}