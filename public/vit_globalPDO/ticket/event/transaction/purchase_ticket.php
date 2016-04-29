<?php

/*
 * 
 */

// ============================================================
// 				INCLUDE
// ============================================================

set_time_limit(700);
$basedir = realpath(__DIR__);
// include db connect class
include($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

	// array for JSON response
$response = array();



// trans.php
function begin(){
	mysql_query("BEGIN");
}

function commit(){
	mysql_query("COMMIT");
}

function rollback(){
	mysql_query("ROLLBACK");
}




// check for required fields
if (isset($_POST['Ticket']) && isset($_POST['USERID']) && isset($_POST['EVENTID'])){
	
	
// ============================================================
// 				VARIABLES
// ============================================================

	// setup vars
	$ticketList = $_POST['Ticket'];
	$userId = $_POST['USERID'];
	$eventId = $_POST['EVENTID'];
	$msg = "";
	
	$obj =  json_decode($ticketList, true);
	// $msg = "OBJ Count: ".count($obj);
	
	$success = true;
	
	
	// set transaction to 0  
	// (forces any currently running phps to unreserve tickets)
	session_id($userId);
	session_start();

	//$response["message"] = $_SESSION['Transaction'].", ".$_SESSION["userId"].", ".$_SESSION["eventId"];

	$_SESSION['Transaction'] = 1;
	$_SESSION["userId"] = null;
	$_SESSION["eventId"] = null;
	
	session_write_close();
	
	
 // ============================================================
 // 				TRANSACTION
 // ============================================================


	begin(); // transaction begins
	$count = 0;
	// foreach tickettype loop
	foreach ($obj as $ticketObj) {
		
		$ticket =  json_decode($ticketObj, true);
		
		$ticketTypeId = $ticket['TICKETTYPEID'];				
		$ticketQuan = $ticket['TICKETQUANTITY'];
		$msg = "Count of Tickets: ".count($ticket);
		// $msg = "ticketTypeId: ".$ticketTypeId.",  quantity: ".$ticketQuan;
		$count += $ticketQuan;
		$query = mysql_query("UPDATE VIT_TICKETTYPE
			SET TICKETRESERVED = (TICKETRESERVED + $ticketQuan),
			TICKETREMAINING = (TICKETREMAINING - $ticketQuan)
			WHERE TICKETREMAINING >= $ticketQuan AND TICKETTYPEID = $ticketTypeId");
		
		if(!mysql_affected_rows()){
			$success = false;
		}
	}
	
	
	
 // ============================================================
 // 				RESULT
 // ============================================================
	
	if($success){
		
    	// COMMIT the transaction
		commit();
		
		
		// On SUCCESS
		$response["success"] = 1;
		$response["message"] = $msg;
		
		// echoing JSON response with flush
		ob_start(); 
		echo json_encode($response);
		//this is for the buffer achieve the minimum size in order to flush data
		echo str_repeat(' ',1024*64);
		ob_flush(); flush();
		
		
	    	// start PHP #2
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, BASEURL . "/ticket/event/purchase_ticket_two.php" );
		curl_setopt($ch, CURLOPT_POSTFIELDS, "Ticket=$ticketList && EVENTID=$eventId && USERID=$userId");
		
		curl_setopt($ch, CURLOPT_USERAGENT, 'api');
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		
		$output = curl_exec($ch);
		curl_close($ch);
		//echo $output;
		
		exit;
		
	} else {
		
	    	// rollback any changes
		rollback();
		
		// On Failed
		$response["success"] = 0;
		$response["message"] = "Not enough tickets in stock to make purchase";
		
		// echoing JSON response
		echo json_encode($response);
		
		exit;
	}
	
} else {
	
	// No vars sent
	$response["success"] = 0;
	$response["message"] = "Oops, an error occurred!";
	
	// echoing JSON response
	echo json_encode($response);
}
?>