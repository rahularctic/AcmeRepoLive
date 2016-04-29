<?php

/*
 * Following code will wait 10 minutes to unreserve tickets
 * if paytabs rejected/cancelled/timed-out
 * The code will unreserve the tickets
 * if paytabs accepts transaction
 * the countdown will cancel 
 * and the tickets will be generated for the user instead
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
$ticketInfoArray = array();
$tidArray = array();



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
	$ticketList= $_POST['Ticket'];
	$userId = $_POST['USERID'];
	$eventId = $_POST['EVENTID'];
	
	$obj =  json_decode($ticketList, true);
	
	$LASTACTIVITY = time();
	$timeout = time()+600;
	$check = false;
	$success = true;
	$transaction = 0;
	
	
	
	
	// set transaction to null
	session_id($userId);
	session_start();
	
	$_SESSION["Transaction"] = null;
	$_SESSION["userId"] = $userId;
	$_SESSION["eventId"] = $eventId;
	
	session_write_close();


 // ============================================================
 // 				SLEEP
 // ============================================================
	
	// SLEEP 10 seconds
	While(!$check){
		
		session_id($userId);
		session_start(); 
		
		
		// break loop if a transaction is sent OR 10 mins are up
		if(isset($_SESSION['Transaction'])){

			// save value of transaction
			if(isset($_SESSION['TransactionRes'])){
				$transaction = $_SESSION['TransactionRes'];
			}
			$_SESSION["Transaction"] = null;
			$_SESSION["TransactionRes"] = null;
			
			session_write_close();
			// break out of loop
			$check = true;

		}else if($LASTACTIVITY >= $timeout){

			$_SESSION["Transaction"] = null;
			$_SESSION["TransactionRes"] = null;
			
			session_write_close();
			
			// break out of loop
			$check = true;
		}else{

			session_write_close();
			sleep(1);
			$LASTACTIVITY++;
		}	
	}
	

 // ============================================================
 // 				QUERIES
 // ============================================================

	
	begin(); // transaction begins
	
	
	
	// IF transaction result is recieved & paytabs successful
	if($transaction == "1"){


		// foreach tickettype loop
		foreach ($obj as $ticketObj) {

			$ticket =  json_decode($ticketObj, true);
			
			$ticketTypeId = $ticket['TICKETTYPEID'];				
			$ticketQuan = $ticket['TICKETQUANTITY'];
			
			
			
			$query1 = mysql_query("UPDATE VIT_TICKETTYPE
				SET TICKETRESERVED = (TICKETRESERVED - $ticketQuan )
				WHERE TICKETRESERVED >= $ticketQuan AND TICKETTYPEID = $ticketTypeId");

			$idList = array();
			
			// generate tickets
			for($c=0; $c<$ticketQuan; $c++){

				# generate a random salt to use for ticket
				$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

				$salted =   $userId.$salt;

				$hashkey = hash('sha256', $salted);

				$query2 = mysql_query("INSERT INTO 
					VIT_TICKET_PURCHASED (USERID, TICKETTYPEID,TICKETHASHKEY)
					VALUES		    ('$userId', '$ticketTypeId','$hashkey')");

				//--------------------------------------------------------------------------------------------------

				$ticketIds = mysql_query("SELECT TICKETID FROM VIT_TICKET_PURCHASED ORDER BY TICKETID DESC LIMIT 1"); //latest ticket ids purchased


				if (mysql_num_rows($ticketIds) > 0) {				

					while($row = mysql_fetch_array($ticketIds)){

						$ticketId = $row["TICKETID"];
						array_push($tidArray,$ticketId);
					}								

				}

				//-----------------------------------------------------------------------------------------------------				

			}
			
			
			// user now attending event
			$result = mysql_query("INSERT INTO VIT_USERATTENDING(USERID, EVENTID) VALUES('$userId','$eventId')");
			

			if(!mysql_affected_rows()){
				$success = false;
			}
		}


		foreach ($tidArray as $value) {


			$query3 = mysql_query("SELECT  VIT_EVENT.EVENTID as EVENTID, VIT_USER.USERID as USERID, TICKETTYPENAME, email, VIT_USER.USERNAME, EVENTPROMOTERNAME.USERNAME as EVENTPROMOTERNAME, TICKETHASHKEY, EVENTNAME, DATE_FORMAT( DATE( EVENTSTART ) ,  '%a, %D %b '  ) as STARTDATE ,  TIME_FORMAT( TIME( EVENTSTART ) ,  '%h %p' )  as STARTTIME, 	
				EVENTLOCATION FROM (SELECT USERNAME FROM VIT_USER INNER JOIN VIT_EVENT ON VIT_EVENT.USERID = VIT_USER.USERID WHERE EVENTID = '$eventId') as EVENTPROMOTERNAME,
				VIT_TICKET_PURCHASED
				INNER JOIN VIT_TICKETTYPE ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
				INNER JOIN VIT_EVENT ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
				INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_TICKET_PURCHASED.USERID
				WHERE TICKETID = '$value'");

			if (mysql_num_rows($query3) > 0) {

				$ticketInfo = array();				

				while($row = mysql_fetch_array($query3)){


					$ticketInfo["EVENTID"] = $row["EVENTID"];
					$ticketInfo["USERID"] = $row["USERID"];
					$ticketInfo["EVENTPROMOTERNAME"] = $row["EVENTPROMOTERNAME"];
					$ticketInfo["EVENTNAME"] = $row["EVENTNAME"];
					$ticketInfo["TICKETTYPENAME"] = $row["TICKETTYPENAME"];
					$ticketInfo["USERNAME"] = $row["USERNAME"];
					$ticketInfo["USEREMAIL"] = $row["email"];
					$ticketInfo["EVENTLOCATION"] = $row["EVENTLOCATION"];
					$ticketInfo["EVENTSTARTDATE"] = $row["STARTDATE"];
					$ticketInfo["EVENTSTARTTIME"] = $row["STARTTIME"];
					$ticketInfo["TICKETHASHKEY"] = $row["TICKETHASHKEY"];

					array_push($ticketInfoArray,$ticketInfo);

				}								
				
			}
		}
		
		$jsonTicketInfo = json_encode($ticketInfoArray);

		
		// start send_ticket PHP 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, BASEURL . "/ticket/event/tickets_send_pdf.php" );
		curl_setopt($ch, CURLOPT_POSTFIELDS, "ticketInfoArray=$jsonTicketInfo");

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



	}else{

		// IF paytabs rejected/cancelled/timed-out
		// foreach tickettype loop
		foreach ($obj as $ticketObj) {

			$ticket =  json_decode($ticketObj, true);
			
			$ticketTypeId = $ticket['TICKETTYPEID'];				
			$ticketQuan = $ticket['TICKETQUANTITY'];

			$result = mysql_query("UPDATE VIT_TICKETTYPE
				SET TICKETRESERVED = (TICKETRESERVED - $ticketQuan),
				TICKETREMAINING = (TICKETREMAINING + $ticketQuan)
				WHERE TICKETRESERVED >= $ticketQuan AND TICKETTYPEID = $ticketTypeId");

			if(!mysql_affected_rows()){
				$success = false;
			}
		}
	}


 // ============================================================
 // 				ECHO RESULT
 // ============================================================

	if($success){

		// On SUCCESS
		$response["success"] = 1;

    	// COMMIT the transaction
		commit();

		// echoing JSON response
		echo json_encode($response);
		exit;
		
	} else {

		// On Failed
		$response["success"] = 0;
		$response["message"] = "Oops, an error occurred!";

	    	// rollback any changes and destroy session
		rollback();

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