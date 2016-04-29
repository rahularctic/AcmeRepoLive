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



// check for post data
if (isset($_POST["userId"])) {
   $userId = $_POST['userId'];
	
	
	// userEmail is FOLLOWING friendEmail
	$query = mysql_query("SELECT U.USERID, U.USERNAME 
			      FROM VIT_FOLLOW f1 
			      INNER JOIN VIT_FOLLOW f2 
			      ON f1.USERID = f2.F_USERID
			      AND f1.F_USERID = f2.USERID
			      INNER JOIN VIT_USER U
			      ON U.USERID = f1.F_USERID 
			      WHERE f1.USERID = '$userId'");
	
	if (mysql_num_rows($query) > 0) {
	
		// looping through all results
		// events node
		$response["User"] = array();

		while ($row = mysql_fetch_array($query)) {
			// temp user array
			$user = array();
			$user["userId"] = $row["USERID"];
			$user["userName"] = $row["USERNAME"];

        		// push all friends into final response array
        		array_push($response["User"], $user);
        		
    		}
			
  		
		// success
		$response["success"] = 1;
		
		
 
		// echoing JSON response
		echo json_encode($response);
  		
	} else {
		// no friends found
		$response["success"] = 0;
		
 
		// echo no users JSON
		echo json_encode($response);
	}
} else {
	// required field is missing
	$response["success"] = 0;
	$response["message"] = "Oops, an error has occurred";
		 
	// echoing JSON response
	echo json_encode($response);
}
?>