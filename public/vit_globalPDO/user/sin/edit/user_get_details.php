<?php
 
/*
 * Following code will get single event details
 * An event is identified by event id (eventId)
 */

$basedir = realpath(__DIR__);
require_once  ($basedir . '/../../../libs/CRUD.php');
$db = new CRUD();
 
// check for post data
if (isset($_POST["USERID"])) {
    $userId = $_POST['USERID'];

    $params =   [
                ":userId" => $userId
                ];
 
    $query = " SELECT * 
                FROM VIT_USER 
                WHERE USERID = :userId";
    $db->executeMySQL($query, $params);
    
    if($db->rowCount() > 0) {

        $db->response["User"] = $db->fetchAll();

        $follower = "SELECT USERID FROM VIT_FOLLOW WHERE F_USERID = :userId";
        $db->executeMySQL($follower, $params);

        if($db->rowCount() > 0){
            $db->response["userFollowers"] = $db->rowCount();
        } else {
            $db->response["userFollowers"] = 0;
        }

        $following = "SELECT USERID FROM VIT_FOLLOW WHERE USERID = :userId";
        $db->executeMySQL($following, $params);

        if($db->rowCount() > 0){
            $db->response["userFollowing"] = $db->rowCount();
        } else {
            $db->response["userFollowing"] = 0;
        }
        
        $db->response["success"] = 1;
        $db->echoSuccess();

    } else {
        $db->response["success"] = 0;
        $db->response["message"] = "No user found";
        $db->echoSuccess();
    }
} else {
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}
?>