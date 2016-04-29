<?php
 
/*
 * Following code will delete a Following relationship from the Follow table
 */
 
$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST['USERID']) && isset($_POST['F_USERID'])) {

    $userId = $_POST['USERID'];
    $f_userId = $_POST['F_USERID'];
    $params =   [
                ":userId" => $userId,
                ":f_userId" => $f_userId
                ];
 
    // mysql DELETE following
    $query = "DELETE FROM VIT_FOLLOW WHERE USERID = :userId AND F_USERID = :f_userId";
    $db->executeMySQL($query, $params);
    $db->echoBoolean("success");
    	
} else {
    // required field is missing
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}

?>