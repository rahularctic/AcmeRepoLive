<?php

/*
 * Following code will check if user is following
 */

$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST["USERID"]) && isset($_POST["F_USERID"])) {

	$userId = $_POST['USERID'];
	$f_userId = $_POST['F_USERID'];
	$params =   [
                ":userId" => $userId,
                ":f_userId" => $f_userId
                ];

	 // displays userid from follow table to check if user exists
	$query = "SELECT USERID FROM VIT_FOLLOW WHERE USERID  = :userId AND F_USERID = :f_userId";
	$db->executeMySQL($query, $params);
	$db->echoBoolean("userFollowing");

} else {
	$db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();
}


?>