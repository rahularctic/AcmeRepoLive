<?php
$basedir = realpath(__DIR__);
require $basedir.'/../../../libs/PHPMailerAutoload.php';
require_once $basedir . '/../../../config/config.php';

if(isset($_POST['hash']) && isset($_POST['email']) && isset($_POST['name']) && isset($_POST['password'])){

	$email = $_POST['email'];
	$name = $_POST['name'];
	$password = $_POST['password'];
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
	$mail->addAddress( $email, $name);  					// Add a recipient
	$mail->isHTML(true);                                  	// Set email format to HTML

	$url = BASEURL . "/user/sin/login/user_verify.php?email=".$email."&hash=".$hash;
	$urlNoSpace = str_replace(' ', '', $url);


	$mail->Subject = 'Signup | Verification';
	$mail->Body    = '

	<!DOCTYPE html>
<html doctype style="vertical-align: baseline; background: #FAFAFA; margin: 0; padding: 0; border: 0; font: 14px; "Open Sans", sans-serif;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EMAIL TITLE</title>
</head>
<body style="vertical-align: baseline; background: #FAFAFA; margin: 0; padding: 0; border: 0; font: 14px/1 "Open Sans", sans-serif;" bgcolor="#FAFAFA">
<style type="text/css">
@font-face {
font-family: "Open Sans"; font-style: normal; font-weight: 300; src: local("Open Sans Light"), local("OpenSans-Light"), url("https://fonts.gstatic.com/s/opensans/v13/DXI1ORHCpsQm3Vp6mXoaTYnF5uFdDttMLvmWuJdhhgs.ttf") format("truetype");
}
@font-face {
	font-family: "Open Sans"; font-style: normal; font-weight: 400; src: local("Open Sans"), local("OpenSans"), url("https://fonts.gstatic.com/s/opensans/v13/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf") format("truetype");
}
@font-face {
	font-family: "Open Sans"; font-style: normal; font-weight: 600; src: local("Open Sans Semibold"), local("OpenSans-Semibold"), url("https://fonts.gstatic.com/s/opensans/v13/MTP_ySUJH_bn48VBG8sNSonF5uFdDttMLvmWuJdhhgs.ttf") format("truetype");
}
blockquote:before {
	content: none;
}
blockquote:after {
	content: none;
}
q:before {
	content: none;
}
q:after {
	content: none;
}
.button:visited {
	color: #f47932; text-decoration: none; font-weight: 600; text-transform: uppercase; border: 1px solid #f47932; border-radius: 4px; padding: 10px 20px; width: auto; display: block; text-align: center;
}
.button:hover {
	color: #f47932; text-decoration: none; font-weight: 600; text-transform: uppercase; border: 1px solid #f47932; border-radius: 4px; padding: 10px 20px; width: auto; display: block; text-align: center;
}
.button:active {
	color: #f47932; text-decoration: none; font-weight: 600; text-transform: uppercase; border: 1px solid #f47932; border-radius: 4px; padding: 10px 20px; width: auto; display: block; text-align: center;
}
.footer a:visited {
	color: #f47932 !important; text-decoration: none;
}
.footer a:hover {
	color: #f47932 !important; text-decoration: none;
}
.footer a:active {
	color: #f47932 !important; text-decoration: none;
}
@media screen and (max-width: 500px) {
	.main_body {
		max-width: 90%;
  }
  .footer {
		max-width: 90%;
  }
}
</style>
<table class="container" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; border-collapse: collapse; border-spacing: 0; max-width: 500px; box-sizing: content-box; display: block; margin: 0 auto; padding: 0; border: 0;"><tr style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;"><td style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;" valign="baseline">
    <table class="main_body" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; border-collapse: collapse; border-spacing: 0; display: table; border-radius: 5px !important; box-shadow: 0px 1px 2px 0px rgba(204,204,204,0.50); overflow: hidden; clear: both; margin: 10px; padding: 0; border: 1px solid #cccccc;">
<tr class="logo" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; height: 100px; background: #f47932; margin: 0; padding: 0; border: 0;" bgcolor="#f47932">
<td style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;" valign="baseline"><img src="http://vitee.net/Vitee_Website_Assets/images/logo-dark.png" alt="Vitee" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; display: block; margin: 0 auto; padding: 1% 0 0; border: 0;"></td>
        </tr>
<tr style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;">
<td class="content" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; text-align: center !important; background: #ffffff; margin: 0; padding: 20px; border: 0;" align="center !important" bgcolor="#ffffff" valign="baseline">
                <h1 style="font-size: 2em; line-height: normal; font-style: normal; font-weight: 300; font-variant: normal; vertical-align: baseline; margin: 0 0 20px; padding: 0; border: 0;">'.$name.'</h1>
                <p style="font-size: normal; line-height: 20pt; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; color: #808080; margin: 0 0 20px; padding: 0; border: 0;">Thank you for joining Vitee:</p>
                <h3 style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;"><a href="'.$url.'" style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline; color: #f47932; text-decoration: none;">ACTIVATE MY ACCOUNT NOW</a></h3>

            </td>
        </tr>
</table>
<table class="footer" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; border-collapse: collapse; border-spacing: 0; display: block; margin: 0 auto; padding: 0; border: 0;">
<tr class="social" style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;">
<td style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;" valign="baseline">
                <ul style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; width: 90px; height: 25px; margin: 0 auto; padding: 0; border: 0; list-style: none;">
<li style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; float: left; margin: 10px; padding: 0; border: 0;"><a href="http://fb.com/vitee.net" target="_blank" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; color: #f47932 !important; text-decoration: none; margin: 0; padding: 0; border: 0;"><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/FB.png" alt="Facebook" style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;"></a></li>
                    <li style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; float: left; margin: 10px; padding: 0; border: 0;"><a href="http://instagram.com/vitee.me" target="_blank" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; color: #f47932 !important; text-decoration: none; margin: 0; padding: 0; border: 0;"><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/INSTA.png" alt="Instagram" style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;"></a></li>
                </ul>
                </ul>
</td>
        </tr>
<tr style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;">
<td class="infomation" style="font-size: normal; border: 0; font-style: normal; font-variant: normal; padding: 0; line-height: normal; margin: 0; font-weight: normal; vertical-align: baseline;" valign="baseline">
                <p style="font-size: normal; line-height: 20pt; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; color: #808080; margin: 0 0 20px; padding: 0; border: 0;">Need help? You can contact us at <a href="mailto:contact@vitee.net?Subject=Help" style="font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; color: #f47932 !important; text-decoration: none; margin: 0; padding: 0; border: 0;">contact@vitee.net</a><br><span style="color: #B3B3B3; font-size: normal; line-height: normal; font-style: normal; font-weight: normal; font-variant: normal; vertical-align: baseline; margin: 0; padding: 0; border: 0;">Copyright © 2016 Vitee, W.L.L. All rights reserved.</span></p>
            </td>
        </tr>
</table>
</td></tr></table>
<!-- CONTAINER -->
</body>
</html>

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

} else if(isset($_POST['email'])) {


	require_once($basedir . '/../../../libs/CRUD.php');
	include_once($basedir . '/../../../gcm/gcm.php');
	$db = new CRUD();

	$email = $_POST['email'];

	$selectParams = [
		":email" => $email
	];
	$select = "	SELECT HASH
					FROM VIT_USERVERIFY
					INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_USERVERIFY.USERID
					WHERE VIT_USER.email = :email";

	$db->executeMySQL($select, $selectParams);

	if($db->rowCount() > 0){
		$result = $db->fetchObj();
		$hash = $result->HASH;

		$url = BASEURL . "/user/sin/email/email_resend.php";
		$data = [
			"hash" => $hash,
			"email" => $email
		];

		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$output = curl_exec($ch);
		curl_close($ch);

		$db->response["success"] = 1;
		$db->echoSuccess();

	} else {
		$db->response["success"] = 0;
		$db->echoSuccess();
	}

} else {

	$db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();

}
?>