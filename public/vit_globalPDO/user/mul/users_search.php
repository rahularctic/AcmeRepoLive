<?php
 
/*
 * Following code will list all the users
 */

$basedir = realpath(__DIR__);
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

// check for post data
if (isset($_POST["searchParams"]) && isset($_POST["switch"]) ) {

    $searchParams = $_POST['searchParams'];
    $switch = $_POST['switch'];
    $params =   [
                ":searchParams" => '%'.$searchParams.'%'
                ];
    
    // search a user from the Users table
    if ($switch == "1") {
        $query = "SELECT *FROM VIT_USER WHERE USERNAME LIKE :searchParams ORDER BY PROMOTER DESC";
    } else {
        $query = "SELECT *FROM VIT_USER WHERE USERNAME LIKE :searchParams ORDER BY PROMOTER DESC LIMIT 0, 5";
    }

    $db->executeMySQL($query, $params);

    if($db->rowCount() > 0) {
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