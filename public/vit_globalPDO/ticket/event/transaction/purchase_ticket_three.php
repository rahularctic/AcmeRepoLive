<?php
 
/*
 * 
 */
 
 // ============================================================
 // 				INCLUDE
 // ============================================================


$response = array();

// check for required fields
if (isset($_POST['USERID'])){

	$userId = $_POST['USERID'];
	
	session_id($userId);	
	session_start();
	
	// if session has been started by php2
	$_SESSION["Transaction"] = 1; 
	
	if(isset($_POST['Transaction'])){
		$_SESSION["TransactionRes"] = $_POST['Transaction']; 
	}
	
	//$response["message"] = $_SESSION['Transaction'].", ".$_SESSION["userId"].", ".$_SESSION["eventId"];
	
	session_write_close();
	
	$response["success"] = 1;
    	echo json_encode($response);
}else{
	$response["success"] = 0;
	$response["message"] = "Oops, an error occurred!";
    	echo json_encode($response);
}
?>