<?php
/**
 * Created by PhpStorm.
 * User: Mac
 * Date: 26/01/2016
 * Time: 11:07
 */
$basedir = realpath(__DIR__);
require_once($basedir . '/../../../../libs/CRUD.php');
$db = new CRUD();

$passError = $passErrorV = "";

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['token']) && !empty($_GET['token'])) {

    $email = $_GET["email"];
    $token = $_GET["token"];

} else {
    $email =  $_POST["email"];
    $token =  $_POST["token"];
}


if($_SERVER["REQUEST_METHOD"] == "POST"){

    if (empty($_POST["password"])) {
        $passError = "Missing Required Field";
    } else {
        if(strlen($_POST["password"]) < 6) {
            $passError = "Password must be longer than 6 characters";
        } else {
            $pass = $_POST["password"];
        }
    }

    if (empty($_POST["passwordV"])) {
        $passErrorV = "Missing Required Field";
    } else {
        if(strlen($_POST["password"]) < 6) {
            $passError = "Password must be longer than 6 characters";
        } else {
            $passV = $_POST["passwordV"];
        }
    }

    if(isset($pass) && !empty($pass) && isset($passV) && !empty($passV) && $pass == $passV){

        $url = BASEURL . "/user/sin/login/password/user_update_password.php";
        $data = [
            "token" => $token,
            "email" => $email,
            "password" => $passV,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;

    } else {
        $passErrorV = "Passwords do not Match";
    }

}

?>

<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link href="http://dev.vitee.net/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <style>
        body 	   	{
            font-family: 'Open Sans', sans-serif;
        }
        .panel		{
            margin-top: 10px;
        }
        .error {
            color: #FF0000;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="statusmsg">Please enter your new details</div>
    <script type='text/javascript'>showMe();</script>

    <div class="panel panel-default" id="showhide">
        <div class="panel-heading">Reset Password</div>
        <div class="panel-body">

            <form class="form-horizontal" role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


                <div class="form-group">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                        <span class="error"><?php echo $passError;?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="passwordV">
                        <span class="error"><?php echo $passErrorV;?></span>
                    </div>
                </div>

                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="token" value="<?php echo $token; ?>">

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>