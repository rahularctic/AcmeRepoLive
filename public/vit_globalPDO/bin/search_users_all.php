<?php
 
/*
 * Following code will list all the events
 */
 
// array for JSON response
$response = array();
 
$basedir = realpath(__DIR__);

  // include db connect class
   require_once($basedir . '/../../config/db_connect.php');
 
// connecting to db
$db = new DB_CONNECT();

// minor fix for description characters
mysql_set_charset("utf8");

// check for post data
if (isset($_POST["searchParams"])) {
    $searchParams = $_POST['searchParams'];
    
    // search an event from Event table
    $result = mysql_query("SELECT *FROM VIT_USER WHERE USERNAME LIKE '%$searchParams%'");
    
    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
        
    $response["User"] = array();
         while ($row = mysql_fetch_array($result)) {
 
            $search = array();
            $search["userId"] = $row ["USERID"];
            $search["userName"] = $row ["USERNAME"];
          
            
            array_push($response["User"], $search);
            
            }
            // success
            $response["success"] = 1;
 
 
            // echoing JSON response
            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
 
            // echo no users JSON
            echo json_encode($response);
        }
    } 
        // echo no users JSON
        echo json_encode($response);
    } else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Oops, an error occurred";
    
     
    // echoing JSON response
    echo json_encode($response);
}

?>