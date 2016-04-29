<?php
 
/*
 * Following code will list all the events
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

// check for post data
if (isset($_POST["USERID"])) {

   $userId = $_POST['USERID'];
 
	$params = [":userId" => $userId];
		
    $query = "	SELECT *
    			FROM VIT_EVENT 
    			INNER JOIN VIT_USER 
    			ON VIT_EVENT.USERID = VIT_USER.USERID 
    			WHERE VIT_EVENT.USERID 
    			IN (SELECT F_USERID FROM VIT_FOLLOW WHERE USERID = :userId) AND EVENTEND > CURDATE()";
	
	 $db->executeMySQL($query, $params);
	 
	if($db->rowCount() > 0){
		$db->echoFull("Event");
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