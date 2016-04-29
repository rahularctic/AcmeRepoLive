<?php

$basedir = realpath(__DIR__);

require_once($basedir . '/../../libs/CRUD.php');
//include_once($basedir . '/../../gcm/gcm.php');
$db = new CRUD();
//$gcm = new GCM();

if (isset($_POST['USERID']) && isset($_POST['F_USERID'])) {

    $userId = $_POST['USERID'];
    $f_userId = $_POST['F_USERID'];
    $params =   [
                ":userId" => $userId,
                ":f_userId" => $f_userId
                ];

    // mysql inserting a new row
    $query = "  INSERT INTO VIT_FOLLOW(USERID, F_USERID) 
                VALUES(:userId, (SELECT USERID FROM VIT_USER WHERE USERID = :f_userId))";
    $db->executeMySQL($query, $params);

    if($db->rowCount() > 0){

        $followedParams =   [
                            ":f_userId" => $f_userId
                            ];
        $query_followed = "SELECT USERNOTIFKEY FROM VIT_USER WHERE USERID = :f_userId";
        $db->executeMySQL($query_followed, $followedParams);
        if($db->rowCount() > 0){
            $followed = $db->fetchObj();
            $notification_key = $followed->USERNOTIFKEY;
        }

        $followingParams =  [
                            ":userId" => $userId
                            ];
        $query_following = "SELECT USERNAME FROM VIT_USER WHERE USERID = :userId";
        $db->executeMySQL($query_following, $followingParams);

        if($db->rowCount() > 0){
            $following = $db->fetchObj();
            $username = $following->USERNAME;
        }

//        $message = array("message" => "$username","activity"=>"followers");
//        $gcm->send_notification($notification_key,$message);

        $db->response["success"] = true;
        $db->echoSuccess();

    } else {
        $db->response["success"] = false;
        $db->echoSuccess();
    }

} else {
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred";
    $db->echoSuccess();
}

?>