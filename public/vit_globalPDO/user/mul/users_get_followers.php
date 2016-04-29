<?php
 
/*
 * This php file displays, who the users are following
 */

$basedir = realpath(__DIR__);
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

// check for post data
if (isset($_POST["USERID"])) {

   	$userId = $_POST['USERID'];
	$params = 	[
			    ":userId" => $userId
			    ];
	$query = "	SELECT VIT_USER.USERID, VIT_USER.USERNAME,VIT_USER.USERIMAGE
				FROM VIT_USER
				INNER JOIN VIT_FOLLOW
				ON VIT_USER.USERID = VIT_FOLLOW.USERID
				WHERE VIT_FOLLOW.F_USERID = :userId";

	$db->executeMySQL($query, $params);

    if($db->rowCount() > 0) {
		$db->response["success"] = 1;
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
?>