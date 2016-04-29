<?php
$basedir = realpath(__DIR__);
require $basedir.'/../../../libs/PHPMailerAutoload.php';

if(isset($_POST['hash']) && isset($_POST['email']) ){ 

$email = $_POST['email'];
$hash = $_POST['hash'];

$mail = new PHPMailer;
 
$mail->isSMTP();                                      	// Set mailer to use SMTP
$mail->Host = 'smtp.zoho.com';                       	// Specify main and backup server
$mail->SMTPAuth = true;                               	// Enable SMTP authentication
$mail->Username = 'noreply@vitee.net';                  // SMTP username
$mail->Password = 'MasterChief23!!';               		// SMTP password
$mail->SMTPSecure = 'tls';                            	// Enable encryption, 'ssl' also accepted
$mail->Port = 587;                                    	// Set the SMTP port number - 587 for authenticated TLS
$mail->setFrom('noreply@vitee.net');     				// Set who the message is to be sent from
$mail->addAddress( $email);  							// Add a recipient
$mail->isHTML(true);                                  	// Set email format to HTML

$url = BASEURL . "/user/sin/login/user_verify.php?email=".$email."&hash=".$hash;
$urlNoSpace = str_replace(' ', '', $url);

 
$mail->Subject = 'Signup | Verification';
$mail->Body    = '
 
<div>Thanks for signing up!</div>
<div>Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</div>
 
<div>Please click this link to activate your account:</div>
<div>'.$urlNoSpace.'</div>

 
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

} else {

	$response["success"] = 0;
	$response["message"] = "Oops, an error occurred";
	
	// echoing JSON response
	echo json_encode($response);
	
	exit; 

}
	
?>