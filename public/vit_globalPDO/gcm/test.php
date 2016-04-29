<?php

echo "hello";

//require_once "../config/file.php";
$basedir = realpath(__DIR__);

include($basedir . '/../config/file.php');

var_dump(get_include_path());


echo "<br>";

var_dump($basedir);



?>