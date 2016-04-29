<?php

require '../../user/sin/PHPMailerAutoload.php';






$mail = new PHPMailer;
 
$mail->isSMTP();                                      	// Set mailer to use SMTP
$mail->Host = 'mail.vitee.net';                       	// Specify main and backup server
$mail->SMTPAuth = true;                               	// Enable SMTP authentication
$mail->Username = 'noreply@vitee.net';                  // SMTP username
$mail->Password = 'MasterChief23!!';               	// SMTP password
$mail->SMTPSecure = 'tls';                            	// Enable encryption, 'ssl' also accepted
$mail->Port = 26;                                    	// Set the SMTP port number - 587 for authenticated TLS
$mail->setFrom('noreply@vitee.net');     		// Set who the message is to be sent from
$mail->addAddress( 'marcel.almutawa@gmail.com', 'marcel');  			// Add a recipient
$mail->isHTML(true);                                  	// Set email format to HTML



 
$mail->Subject = 'Signup | Verification';
$mail->Body    = '
 
<div>Thanks for signing up!</div>
<div>Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</div>
 
<div>------------------------</div>
<div>Username: </div>
<div>Password: </div>
<div>------------------------</div>
 
<div>Please click this link to activate your account:</div>
<div></div>

 
'; // Our message above including the link;

	if(!$mail->Send()) {
	  echo 'Message was not sent.';
	  echo 'Mailer error: ' . $mail->ErrorInfo;
	  exit;
	} else {
	  echo 'Message has been sent.';
	  
	$response["success"] = 1;
	$response["message"] = "Sent";
	
	// echoing JSON response
	echo json_encode($response);
	
	exit;  
	  
	}


?>