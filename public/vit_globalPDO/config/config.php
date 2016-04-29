<?php
 
/*
 * All database connection variables
 */

define('DB_USER', getenv('DB_USER')); // db user
define('DB_PASSWORD', getenv('DB_PASS')); // db password (mention your db password here)
define('DB_DATABASE', getenv('DB_NAME')); // database name
define('DB_SERVER',getenv('DB_HOST')); // db server

/*
 * Google API Key
 */
define("GOOGLE_API_KEY", "AIzaSyDEs6h6MYeVQQ6M_uNArrj6c-pJapy0d8U");
define("PROJECT_ID", "293322596259");


/*
 * APP Key
 */
define("APP_KEY", "rmunDm#SlkhDlLu_F*tp4maSH4b1TKbP");

/*
 * Base URL
 */
define("BASEURL", getenv('BASEURL'));

/*
 * AWS - Settings
 */

define("awsAccessKey", getenv('Aws_Access_Key'));
define("awsSecretKey", getenv('Aws_Secret_Key'));
define("awsRegion", getenv('Aws_Region'));
define("awsBucketName", getenv('Aws_Bucket_Name'));
define("awsVersion", "latest");
define("awsBucketURL",getenv('Aws_Bucket_URL'))

?>