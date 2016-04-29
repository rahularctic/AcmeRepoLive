<?php
 
/*
 * Following code will list all the categories
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

$result = "SELECT * FROM VIT_EVENTTYPE";

$db->executeMySQL($result);

if($db->rowCount() > 0){	
		
	$db->echoFull("Categories");

} else {
	$db->response["success"] = 0;
	$db->echoSuccess();
}

?>