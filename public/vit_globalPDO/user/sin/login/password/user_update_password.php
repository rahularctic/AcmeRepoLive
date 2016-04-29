<!DOCTYPE html>
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<style>
body 	   {
		    font-family: 'Open Sans', sans-serif;
		   }
.container {
	    width: 900px;
	    height: 900px;
	    margin-left: auto;
	    margin-right: auto;
	   }
.statusmsg {
		    color: #34495e;
		    font-size: 72px;
	        width: auto;
		    margin-left: auto;
		    margin-right: auto;
		    margin-top: 100px;
		   }
.statusmsg {
		    text-align: center;
		   }
.sImage	   {
            width: 48px;
		    margin-left: auto;
		    margin-right: auto;
		    margin-top: 40px;
		    margin-bottom: 40px;
		   }
.welcome   {
            color: #34495e;
            font-size: 30px;
            width: 550px;
		    margin-left: auto;
		    margin-right: auto;
		    margin-top: 40px;
		    text-align: center;
		   }
.check	   {
		    width: 100px;
	  	    height: 100px;
	  	    margin-top: 40px;
		    margin-left: auto;
		    margin-right: auto;
		   }
	a	   {
		    background-color: #f47932;
		    border-style: none;
		    border-radius: 0;
		    padding: 12px 12px;
		    color: #fff;
		    text-decoration: none;
		    width: auto;
		   }
.close	   {
		    width:130px;
		    margin-top: 40px;
		    margin-left: auto;
		    margin-right: auto;
           }
</style>
</head>
<body>
<div class="container">

<?php
/*
 * Following code will update a user's profile page information
 */
 
$basedir = realpath(__DIR__);
require_once($basedir . '/../../../../libs/CRUD.php');
require_once($basedir . '/password.php');
$db = new CRUD();

if (isset($_POST['email']) && isset($_POST['token']) && isset($_POST['password'])) {

	$email = $_POST['email'];
	$token = $_POST['token'];
	$password = $_POST['password'];
	$passE = password_hash($password, PASSWORD_DEFAULT, array("cost" => 10));
	
	$params = 	[
				":email" => $email,
				":token" => $token
				];
	$query = "	SELECT *
		     	FROM password_resets
		    	WHERE email = :email AND token = :token";
    
    $db->executeMySQL($query, $params);

    if($db->rowCount() > 0){

    	$insertParams = [
    					":passE" => $passE,
    					":email" => $email
    					];
     	
     	$insert = "	UPDATE VIT_USER
     			    SET password = :passE
			      	WHERE email = :email";

      	$db->executeMySQL($insert, $insertParams);		
				
		echo '<div class="statusmsg">Success!</div>';
		echo '<div class="check"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><style>.style0{fill: orange;}</style><path d="M0 0h48v48H0z" fill="none"/><path d="M24 4C12.95 4 4 12.95 4 24c0 11.04 8.95 20 20 20 11.04 0 20-8.96 	20-20 0-11.05-8.96-20-20-20zm-4 30L10 24l2.83-2.83L20 28.34l15.17-15.17L38 16 20 34z" fill="#f47932"/></svg></div>';
		echo '<div class="welcome">Your Password Has Been Changed</div>';
		echo '<div>You may now exit this window</div>';
		
		$deleteParams = [
						":email" => $email
						];
		$delete = "	DELETE FROM password_resets
				    WHERE email = :email";

	    $db->executeMySQL($delete, $deleteParams);
		
	    } else {
			echo '<div class="statusmsg"><p>Failed!</p></div>';
			echo '<div class="welcome">Invalid approach, please use the link that has been send to your email.</div>';
			echo '<div>You may now exit this window</div>';
			echo '<div><p>'.$email.'</p></div>';

//			echo '<div class="statusmsg"><p>'.$email.'</p></div>';
//			echo '<div class="statusmsg"><p>'.$token.'</p></div>';


	    }


} else { // close isset
	$db->response["success"] = 0;
	$db->response["message"] = "Oops, an error occurred";
	$db->echoSuccess();
}
?>


</div>

<script>
    function closeWindow() {
        window.open('','_self','');
        window.close();
    }
</script> 
</body>
</html>