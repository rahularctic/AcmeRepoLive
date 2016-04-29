<?php

/*
 * Following code is a template for the PHPS
 */

 // ============================================================
 // INCLUDE
 // ============================================================


$basedir = realpath(__DIR__);

// include db connect class
require_once($basedir . '/../config/db_connect.php');

// connecting to db
$db = new DB_CONNECT();

// array for JSON response
$response = array();

// minor fix for description characters
mysql_set_charset("utf8");

function begin(){
	mysql_query("BEGIN");
}

function commit(){
	mysql_query("COMMIT");
}

function rollback(){
	mysql_query("ROLLBACK");
}



// ============================================================
// INSERT AND DELETE FUNCTIONS
// ============================================================

function insertAndResponse($query, $message = NULL) {

	begin();

	$insert = mysql_query($query);

	if (mysql_affected_rows() > 0) {
		commit();
		$response["success"] = 1;		
		if (!is_null($message)) {
			$response["message"] = "Success: ".$message;
		}
		echo json_encode($response);
	} else {
		rollback();
		$response["success"] = 0;		
		if (!is_null($message)) {
			$response["message"] = "Failed: ".mysql_affected_rows();
		}
		echo json_encode($response);
	}

}


// ============================================================
// UPDATE FUNCTIONS
// ============================================================

function updateAndResponse($query, $message = NULL){

	begin();

	$update = mysql_query($query);

	if (mysql_affected_rows() > 0) {
		commit();
		$response["success"] = 1;		
		if (!is_null($message)) {
			$response["message"] = "Success: ".$message;
		}
		echo json_encode($response);
	} else {
		rollback();
		$response["success"] = 0;		
		if (!is_null($message)) {
			$response["message"] = "Failed: ".$message;
		}
		echo json_encode($response);
	}
}


// ============================================================
// SELECT FUNCTIONS
// ============================================================

function selectAndResponse($query, $message = NULL) {
	$select = mysql_query($query);

	if (mysql_num_rows($select) > 0){
		$response["success"] = 1;		
		if (!is_null($message)) {
			$response["message"] = "Success: ".$message;
		}
		echo json_encode($response);
	} else {
		$response["success"] = 0;		
		if (!is_null($message)) {
			$response["message"] = "Failed: ".$message;
		}
		echo json_encode($response);
	}
}

function selectBoolean($query, $responseString, $message = NULL) {
	$select = mysql_query($query);

	$response[$responseString] = (mysql_num_rows($select) > 0);
		
	$response["success"] = 1;	

	if (!is_null($message)) {
		$response["message"] = "Success: ".$message;
	}
	echo json_encode($response);
}

function selectAndResponseArray($query, $array, $responseString, $case = NULL, $message = NULL) {

	$select = mysql_query($query);

	if (mysql_num_rows($select) > 0){
		$response[$responseString] = array();
		while ($row = mysql_fetch_array($select)) {
			$selectResponse = array();
			foreach ($array as $key => $value) {
				$selectResponse[$key] = $row[$value];
			}


			if (!is_null($case)) {

				$dtb = new DateTime($row[$case]);
				$today = new DateTime('now');

				if ($today < $dtb || is_null($dtb)) {
					array_push($response[$responseString], $selectResponse);
				}	
			} else {
				array_push($response[$responseString], $selectResponse);
			}
		}

		// success
		$response["success"] = 1;

		if (!is_null($message)) {
			$response["message"] = "Success: ".$message;
		}

		// echoing JSON response
		echo json_encode($response);
	} else {
		$response["success"] = 0;		
		if (!is_null($message)) {
			$response["message"] = "Failed: ".$message;
		}
		echo json_encode($response);
	}
}


function selectMin($query, $selectResponse) {
	$select = mysql_query($query);
	$selectResponse["responseString"] = mysql_num_rows($select);
}

?>
