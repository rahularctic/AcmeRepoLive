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
require_once($basedir . '/../../../libs/CRUD.php');
$db = new CRUD();

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
	
	// Verify data
	$email = $_GET['email']; // Set email variable
	$hash = $_GET['hash']; // Set hash variable

	$params = 	[
				":email" => $email,
				":hash" => $hash
				];
	
	$exists = "	SELECT VIT_USER.email, VIT_USER.ACTIVE, VIT_USERVERIFY.HASH 
				FROM VIT_USER
				INNER JOIN VIT_USERVERIFY
				ON VIT_USER.USERID = VIT_USERVERIFY.USERID
				WHERE email = :email AND HASH = :hash";
	
	$db->executeMySQL($exists, $params);
	
	if($db->rowCount() > 0){
		$match1 = $db->rowCount();
	}
	
	$search = "	SELECT VIT_USER.email, VIT_USER.ACTIVE, VIT_USERVERIFY.HASH 
				FROM VIT_USER
				INNER JOIN VIT_USERVERIFY
				ON VIT_USER.USERID = VIT_USERVERIFY.USERID
				WHERE email = :email AND HASH = :hash AND ACTIVE = '0' ";

	$db->executeMySQL($search, $params);
	
	if($db->rowCount() > 0){
		$match = $db->rowCount();
	}	
	
	if($match1 > 0 && $match == null){
	
		echo '<div class="statusmsg"><p>Failed!</p></div>';
    	echo '<div class="welcome">Account has already been activated</div>';
    	echo '<div class="close"><a href="javascript:closeWindow();">Close Window</a></div>';
	
	} else if($match > 0) {
	    
	    $updateParams = [
	    				":email" => $email
	    				];
		$update = "	UPDATE VIT_USER 
					SET ACTIVE='1' 
					WHERE email = :email AND ACTIVE='0'";
		$db->executeMySQL($update, $updateParams);
				
		echo '<div class="statusmsg">Success!</div>';
		echo '<div class="check"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><style>.style0{fill: orange;}</style><path d="M0 0h48v48H0z" fill="none"/><path d="M24 4C12.95 4 4 12.95 4 24c0 11.04 8.95 20 20 20 11.04 0 20-8.96 20-20 0-11.05-8.96-20-20-20zm-4 30L10 24l2.83-2.83L20 28.34l15.17-15.17L38 16 20 34z" fill="#f47932"/></svg></div>';
		echo '<div class="welcome">Welcome to Vitee</div>';
		echo '<div class="close"><a href="javascript:closeWindow();">Close Window</a></div>';
	} else {
    	// No match -> invalid url or account has already been activated.
    	// Invalid approach
		echo '<div class="statusmsg"><p>Failed!</p></div>';
    	echo '<div class="welcome">Invalid approach, please use the link that has been send to your email.</div>';
    	echo '<div class="close"><a href="javascript:closeWindow();">Close Window</a></div>';
	}	
	
} else {
    	
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred";
    
}
?>

</div>

<script>
    function closeWindow() {
        window.open('','_parent','');
        window.close();
    }
</script> 
</body>
</html>