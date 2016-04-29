<?php


$basedir = realpath(__DIR__);

	require_once($basedir . '/../../config/db_connect.php');
	
	// connecting to db
	$db = new DB_CONNECT();
	
	$ticketInfoArray = array();
	
	$response = array();

/*
	
	$tidArray = array(); 
	
	//$ticketQuan = 2;
	
							
			//--------------------------------------------------------------------------------------------------
			
			//$ticketId = mysql_insert_id(); //latest ticket id purchased
			
			$ticketIds = mysql_query("SELECT TICKETID FROM VIT_TICKET_PURCHASED ORDER BY TICKETID DESC LIMIT 2"); //latest ticket ids purchased
			
							
			if (mysql_num_rows($ticketIds ) > 0) {				
							
			while($row = mysql_fetch_array($ticketIds)){
	        	    
	        	    
	        	  
		       
		        $ticketId = $row["TICKETID"];
		        
		        
			array_push($tidArray,$ticketId);

							
			}								
				
		}
		
		//$response["message"] = $tidArray;
		
		//echo json_encode($response);
		
		
		
			//$tid = sizeof($tidArray);
			
			
			
			
			foreach ($tidArray as $value) {

				$query3 = mysql_query("SELECT  VIT_EVENT.EVENTID as EVENTID, VIT_USER.USERID as USERID, TICKETTYPENAME, email, VIT_USER.USERNAME, EVENTPROMOTERNAME.USERNAME as EVENTPROMOTERNAME, TICKETHASHKEY, EVENTNAME, DATE_FORMAT( DATE( EVENTSTART ) ,  '%a, %D %b '  ) as STARTDATE ,  TIME_FORMAT( TIME( EVENTSTART ) ,  '%h %p' )  as STARTTIME, 	
							EVENTLOCATION FROM (SELECT USERNAME FROM VIT_USER INNER JOIN VIT_EVENT ON VIT_EVENT.USERID = VIT_USER.USERID WHERE EVENTID = '$eventId') as EVENTPROMOTERNAME,
							VIT_TICKET_PURCHASED
							INNER JOIN VIT_TICKETTYPE ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
							INNER JOIN VIT_EVENT ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
							INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_TICKET_PURCHASED.USERID
							WHERE TICKETID = 6");			

							
			if (mysql_num_rows($query3) > 0) {
			
			$ticketInfo = array();				
							
			while($row = mysql_fetch_array($query3)){
	        
		       
		        $ticketInfo["eventId"] = $row["EVENTID"];
		        $ticketInfo["userId"] = $row["USERID"];
		        $ticketInfo["eventName"] = $row["EVENTNAME"];
		        $ticketInfo["ticketTypeName"] = $row["TICKETTYPENAME"];
		        $ticketInfo["userName"] = $row["USERNAME"];
		        $ticketInfo["userEmail"] = $row["email"];
		        $ticketInfo["eventLocation"] = $row["EVENTLOCATION"];
		        $ticketInfo["eventStartDate"] = $row["STARTDATE"];
		        $ticketInfo["eventStartTime"] = $row["STARTTIME"];
		        $ticketInfo["ticketHashKey"] = $row["TICKETHASHKEY"];
		
			array_push($ticketInfoArray,$ticketInfo);
		
							
			}								
				
		}
	}	
	*/
	
	$fields = array("hello" => "a","hello1" => "b" );

		array_push($ticketInfoArray,$fields );
	
	$jsonTicketInfo = json_encode($ticketInfoArray);
	
	
	
			
				
		// start send_ticket PHP 
	    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://www.vitee.net/vit_ios/ticket/event/send_ticket.php" );
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
		
		
		//$response["message"] = $ticketInfoArray;
		
		//echo json_encode($json);
		
		
		
		echo $jsonTicketInfo;
							
	?>		//hello-----------------------------------------------------------------------------------------------------	