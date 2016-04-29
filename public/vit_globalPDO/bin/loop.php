<?php
/*
 * Following code will update a user's profile page information
 */

// array for JSON response
$response = array();

 //=================================
 // 			INCLUDE
 //=================================
 
$basedir = realpath(__DIR__);

// include db connect class
require_once($basedir . '/../../config/db_connect.php');

// connecting to db
$db = new DB_CONNECT();

for ($i=0; $i<6; $i++){

	$minutes_to_add = 2880;

	$time = $time = new DateTime('2015-05-28 05:05');
	//$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
	
	$stamp = $time->format('Y-m-d H:i');
	
	$insert = mysql_query("INSERT INTO VIT_TICKET_PURCHASED (USERID, TICKETTYPEID, TIMEOFPURCHASE)
							  VALUES('220', '21', '$stamp')");
							  
	if(mysql_affected_rows()){
	
		echo 'success';	
		
	} else {
	
		echo 'failed';
		
	}					  	

}

//$insert = mysql_query("INSERT INTO VIT_TICKET_PURCHASED (USERID, TICKETTYPEID)
//						  VALUES('188', '19')");

							  
//$insert = mysql_query("INSERT INTO VIT_TICKET_PURCHASED (USERID, TICKETTYPEID)
//						  VALUES('220', '20')");
						  
//$insert = mysql_query("INSERT INTO VIT_TICKET_PURCHASED (USERID, TICKETTYPEID)
//VALUES('220', '21')");