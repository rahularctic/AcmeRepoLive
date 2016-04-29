<?php

$basedir = realpath(__DIR__);

include_once($basedir . '/../../../libs/Image_S3.php');
include_once($basedir . '/CRUD.php');




$db = new CRUD();
//$gcm = new GCM();

$checkInterest = true;

// check for required fields
if ( isset($_POST['token'])&& isset($_POST['gcm_regId'])) {

    $token = $_POST['token'];
    $gcm_regId = $_POST['gcm_regId'];

    $user_details = "https://graph.facebook.com/me?access_token=".$token;
    $user_picture = "https://graph.facebook.com/me/picture?width=300&height=300&access_token=".$token;
    $user_friends = "https://graph.facebook.com/me/friends?access_token=".$token;

    $json = file_get_contents($user_details);
    $obj = json_decode($json);
    $userName = $obj->{'name'};
    $userEmail = $obj->{'email'};
    $userGender = null;
    $userBirthday = null;
    if(isset($obj->{'gender'})){
        $userGender = $obj->{'gender'};
    }
    if(isset($obj->{'birthday'})){

        $userBirthday = $obj->{'birthday'};
    }




    $checkInterestsParams = [
        ":userEmail" => $userEmail
    ];

    $checkInterests = "	SELECT *
				       	FROM VIT_USER
				       	INNER JOIN VIT_USER_EXTRA 
				       	ON VIT_USER.USERID = VIT_USER_EXTRA.USERID
				       	WHERE email = :userEmail";

    $db->executeMySQL($checkInterests, $checkInterestsParams);

    // if user has interest, they have already done the interest process
    // this is not first login (false)
    if($db->rowCount() > 0){
        $checkInterest = false;
    }

    // query to check whether the user already exist or not
    $userCheck = "	SELECT *
					FROM VIT_USER 
					WHERE email = :userEmail";

    $db->executeMySQL($userCheck, $checkInterestsParams);

    if($db->rowCount() > 0){

        $result = $db->fetchObj();
        $rowCount = $db->rowCount();
        $userID = $result->USERID;

        if ($result->ACTIVE == 0){
            $updateActive = "UPDATE VIT_USER SET ACTIVE = '1'";
            $db->executeMySQL($updateActive);

            if($db->rowCount() > 0) {
                $db->response["success"] = 1;
                $db->response["USERID"] = $userID;
                $db->response["email"] = $userEmail;
                $db->response["USERNAME"] = $userName;
                $db->response["fL"] = $checkInterest;
                $db->echoSuccess();
            } else {
                $db->response["success"] = 0;
                $db->echoSuccess();
            }
        } else {
            $db->response["success"] = 1;
            $db->response["USERID"] = $userID;
            $db->response["email"] = $userEmail;
            $db->response["USERNAME"] = $userName;
            $db->response["fL"] = $checkInterest;
            $db->echoSuccess();
        }


    } else {

        // in the case that the user doesn't exist , we create a  new record
        $insertParams =	[
            ":userEmail" => $userEmail,
            ":userName" => $userName,
            ":userGender" => $userGender,
            ":userBirthday" => $userBirthday
        ];

        $insert = "	INSERT INTO VIT_USER(email, USERNAME, USERGENDER,DOB, ACTIVE)
	   				VALUES(:userEmail,:userName, :userGender, STR_TO_DATE(:userBirthday, '%m/%d/%Y'),'1')";

        $db->executeMySQL($insert, $insertParams);

        if($db->isInserted()) {
            $userId = $db->isInserted();
        } else {
            $db->echoSuccess();
            exit;
        }


        $db->response["USERID"] = $userId;
        $db->response["USEREMAIL"] = $userEmail;
        $db->response["USERNAME"] = $userName;
        $db->response["fL"] = true;

/*
        // successfully inserted into database
        $jsonFriends = file_get_contents($user_friends);
        $friends= json_decode($jsonFriends, true);

        foreach ($friends['data'] as $friendName) {
            $f = $friendName['name'];

            $friendParams = [
                ":userId" => $userId,
                ":friendName" => $f
            ];

            $friends = "INSERT INTO VIT_FOLLOW(USERID, F_USERID)
							VALUES(:userId, (SELECT USERID FROM VIT_USER WHERE USERNAME = :friendName))";

            $db->executeMySQL($friends, $friendParams);
        }
*/

        // ----------  UPLOAD IMAGE TO S3 BUCKET   -----------

        //convert image to a string resource
        $img = file_get_contents($user_picture);

        //generate the path for the image
        $imagePath = "img/user/".$userId."/";
        $imageName =  time().rand(111, 999).".jpeg";

        $params = [
            ":imageName" => $imageName,
            ":userId" => $userId
        ];

        if(isset($img)){

          if(uploadUserImgSN($img,$imagePath.$imageName)){
                $updateUserImage = "UPDATE VIT_USER SET USERIMAGE = :imageName WHERE USERID = :userId";
                $db->executeMySQL($updateUserImage, $params);
            }

        }else{

            $default_img = file_get_contents(awsBucketURL."/img/user/default.jpeg");
            if(uploadUserImgSN($default_img,$imagePath.$imageName)){
                $updateUserImage = "UPDATE VIT_USER SET USERIMAGE = :imageName WHERE USERID = :userId";
                $db->executeMySQL($updateUserImage, $params);
            }

        }

        $db->echoSuccess();

    }



} else {
    // required field is missing
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, a token error has occurred";
    $db->echoSuccess();
}






?>