<?php
 
/*
 * Following code will list all the events
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["searchParams"]) && isset($_POST["switch"])) {

    $searchParams = $_POST['searchParams'];
    $switch = $_POST['switch'];

	$params = [":searchParams" => '%'.$searchParams.'%'];

    if ($switch == "1") {
	    $query = "	SELECT *
					FROM VIT_EVENT 
					INNER JOIN VIT_USER
					ON VIT_EVENT.USERID = VIT_USER.USERID
					WHERE EVENTNAME 
					LIKE :searchParams AND EVENTEND > CURDATE() ";
	 			
	
					
					
	} else {
		$query = "	SELECT *
					FROM VIT_EVENT 
					INNER JOIN VIT_USER
					ON VIT_EVENT.USERID = VIT_USER.USERID
					WHERE EVENTNAME  
					LIKE :searchParams AND EVENTEND > CURDATE()
					LIMIT 0,5";
	}
	
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