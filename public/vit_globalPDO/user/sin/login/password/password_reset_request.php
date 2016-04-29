<?php
/*
 * Following code will update a user's profile page information
 */
 
$basedir = realpath(__DIR__);
require_once($basedir . '/../../../../libs/CRUD.php');
$db = new CRUD();

if (isset($_POST['email'])) {

	$email = $_POST['email'];
	$token1 = md5( rand(0,1000) );
	$token2	= md5( rand(0,1000) );
	$token = $token1.$token2;
	
	$params = 	[
				":email" => $email
				];
	$query = "	SELECT email
				FROM VIT_USER
				WHERE email = :email";
	$db->executeMySQL($query, $params);

	if($db->rowCount() > 0){

		$params1 = 	[
					":email" => $email,
					":token" => $token
					];
		$insert = "	INSERT INTO password_resets (email, token)
					VALUES(:email, :token)";

		$db->executeMySQL($insert, $params1);
							
		if($db->rowCount() > 0){
			
			$url = BASEURL . "/user/sin/login/password/password_reset_send_email.php";
			$data = [
					"token" => $token,
					"email" => $email
					];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			
			$output = curl_exec($ch);
			curl_close($ch);
			
			$db->response["success"] = 1;
			$db->response["message"] = $output;
			$db->echoSuccess();
			exit;
			
		} else {
			$db->response["success"] = 3;
			$db->echoSuccess();
		}
		
	} else {
	
		$db->response["success"] = 2;
		$db->echoSuccess();
	}

} else {

	$db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();

}

?>