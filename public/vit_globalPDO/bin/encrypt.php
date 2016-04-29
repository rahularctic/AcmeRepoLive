<?php
/*
 * Following code will update a user's profile page information
 */


 //=================================
 // 		INCLUDE
 //=================================

require 'password.php';


$key = "rmunDm#SlkhDlLu_F*tp4maSH4b1TKbP";

if (isset($_POST['value'])){

echo $_POST['value'].' '.'--';
$password = $_POST['value'];

$hash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));

echo $hash;

echo "<br />";

//$passwordE = crypt($password, $key);
//echo "encrypted Password: ".$passwordE."<br />";

echo "\n";

echo $_POST['value1'].' '.'--';
$password2 = $_POST['value1'];

//$passwordE2 = crypt($password2, $key);
//echo "encrypted Password: ".$passwordE2;


} else {
	echo "fuck you";
}

?>


<form method="post" action="">
<input type="text" name="value">
<input type="submit">

<br>
<br>

<input type="text" name="value1">
<input type="submit">
</form>


<?php

if (password_verify($password2, $hash)) {
        /* Valid */
        echo "Success! Valid password";
    } else {
        /* Invalid */
        echo "Invalid password";
    }

?>