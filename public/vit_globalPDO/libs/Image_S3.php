<?php
/**
 * Created by PhpStorm.
 * User: SAM-PC
 * Date: 12/27/2015
 * Time: 1:46 PM

 */


set_time_limit(5000);

/**
 * AWS PHP SDK Documentation - http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#deleteobjects
 */

// ============================================================
// 						INCLUDE
// ============================================================

$basedir = realpath(__DIR__);

// include config files
//require_once($basedir . '/../config/config.php');

require_once($basedir . '/aws/aws-autoloader.php');

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

function updateUserImg($image,$imagePath,$thumbWidth,$width,$height){

    $credentials = new Credentials(awsAccessKey, awsSecretKey);

// Instantiate an Amazon S3 client.
    $s3 = S3Client::factory(array(
        'credentials' => $credentials,
        'region' => awsRegion,
        'version' => awsVersion

    ));



    // calculate thumbnail size
    if($thumbWidth != 0 && $width > $thumbWidth) {
        $new_width = $thumbWidth;
        $new_height = floor( $thumbWidth * ( $height/$width ) );
    }else{
        $new_height = $height;
        $new_width = $width;
    }

    // create container for the image of width = new_width and height = new_height
    $tmp_img = imagecreatetruecolor($new_width, $new_height);


    // copy and resize old image into new image
    imagecopyresized($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Output the image
    ob_start();
    imagejpeg($tmp_img, null);
    $tempImg = ob_get_contents();
    ob_end_clean();
    // Free up memory
    imagedestroy($tmp_img);


    /**
     * Upload to S3 bucket - AWS
     * */
    try {
        $result = $s3->putObject([
            'Bucket' => awsBucketName,
            'Key' => $imagePath,
            'Body' => $tempImg,
            'ACL' => 'public-read',
            'ContentType' => 'image/jpeg'
        ]);

    }catch (S3Exception $e){

        return false;
    }

    if($result['@metadata']['statusCode'] == 200){
        return true;
    }else{

        return false;
    }

}



function uploadUserImgSN($image,$imagePath){

    $credentials = new Credentials(awsAccessKey, awsSecretKey);

// Instantiate an Amazon S3 client.
    $s3 = S3Client::factory(array(
        'credentials' => $credentials,
        'region' => awsRegion,
        'version' => awsVersion

    ));


    /**
     * Upload to S3 bucket - AWS
     * */
    try {
        $result = $s3->putObject([
            'Bucket' => awsBucketName,
            'Key' => $imagePath,
            'Body' =>$image,
            'ACL' => 'public-read',
            'ContentType' => 'image/jpeg'
        ]);

    }catch (S3Exception $e){

        return false;
    }

    if($result['@metadata']['statusCode'] == 200){
        return true;
    }else{

        return false;
    }

}


function uploadEventImg($image,$imagePath,$thumbWidth,$width,$height){

    $credentials = new Credentials(awsAccessKey, awsSecretKey);

// Instantiate an Amazon S3 client.
    $s3 = S3Client::factory(array(
        'credentials' => $credentials,
        'region' => awsRegion,
        'version' => awsVersion

    ));



    // calculate thumbnail size
    if($thumbWidth != 0 && $width > $thumbWidth) {
        $new_width = $thumbWidth;
        $new_height = floor( $thumbWidth * ( $height/$width ) );
    }else{
        $new_height = $height;
        $new_width = $width;
    }

    // create container for the image of width = new_width and height = new_height
    $tmp_img = imagecreatetruecolor($new_width, $new_height);


    // copy and resize old image into new image
    imagecopyresized($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Output the image
    ob_start();
    imagejpeg($tmp_img, null);
    $tempImg = ob_get_contents();
    ob_end_clean();
    // Free up memory
    imagedestroy($tmp_img);


    /**
     * Upload to S3 bucket - AWS
     * */
    try {
        $result = $s3->putObject([
            'Bucket' => awsBucketName,
            'Key' => $imagePath,
            'Body' => $tempImg,
            'ACL' => 'public-read',
            'ContentType' => 'image/jpeg'
        ]);

    }catch (S3Exception $e){

        return false;
    }

    if($result['@metadata']['statusCode'] == 200){
        return true;
    }else{

        return false;
    }

}


function getEventHeaderImages($eventID){

    $images = [];

    $credentials = new Credentials(awsAccessKey, awsSecretKey);

// Instantiate an Amazon S3 client.
    $s3 = S3Client::factory(array(
        'credentials' => $credentials,
        'region' => awsRegion,
        'version' => awsVersion
    ));

//get image list (images path) inside header folder
    try {
    $objects = $s3->getIterator('ListObjects', array(
        "Bucket" => awsBucketName,
        "Prefix" => 'img/event/'.$eventID.'/header'
    ));

    }catch (S3Exception $e){

        return $images;
    }

//retrieve the name of image from the image path
    foreach ($objects as $object) {

        $image  = substr(strrchr($object['Key'], "/"),1);

        $images [] = ''.$image;
    }

return $images;


}


function deleteEventImage($eventID,$imageName){

    $credentials = new Credentials(awsAccessKey, awsSecretKey);

// Instantiate an Amazon S3 client.
    $s3 = S3Client::factory(array(
        'credentials' => $credentials,
        'region' => awsRegion,
        'version' => awsVersion

    ));


    $key_objects = array(
        array('Key'=>'img/event/'.$eventID.'/'.$imageName),
        array('Key'=>'img/event/'.$eventID.'/header/'.$imageName),
        array('Key'=>'img/event/'.$eventID.'/thumbnails/'.$imageName)
    );

try{
    $result = $s3->deleteObjects([
        'Bucket' =>  awsBucketName, // REQUIRED
        'Delete' => [ // REQUIRED
            'Objects' => $key_objects,
        ],
    ]);


}catch (S3Exception $e){

    return false;
}

    if($result['@metadata']['statusCode'] == 200){

        return true;

    }else{

        return false;
    }




}









?>