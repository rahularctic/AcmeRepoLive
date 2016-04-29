<?php
/*
 * Following code will update a user's profile page information
 */
 
$basedir = realpath(__DIR__);
require_once  ($basedir . '/../../../libs/CRUD.php');
$db = new CRUD();

if ( isset($_POST['USERID']) && isset($_POST['Categories']) ) {

	$userId = $_POST['USERID'];
	$interests = $_POST['Categories'];
	$success = 0;
	
	$list =  json_decode($interests, true);

    // get event from events table
    $query = "	SELECT VIT_USER.USERID, VIT_USER.USERNAME,VIT_USER.USERIMAGE
			    FROM VIT_EVENT
			    INNER JOIN VIT_USER
			    ON VIT_EVENT.USERID = VIT_USER.USERID
			    WHERE EVENTTYPEID IN (".implode(',',$list).") AND VIT_USER.PROMOTER = 1
			    GROUP BY VIT_USER.USERID";

    $db->executeMySQL($query);
    
    if($db->rowCount() >0) {
    	$db->echoFull("User");
    } else {
    	$db->response["success"] = 0;
    	$db->echoSuccess();
    }

} else {
	$db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}