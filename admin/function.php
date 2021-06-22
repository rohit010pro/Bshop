<!-- ###   Functions for Admin Panel  ### -->
<?php
require_once("connection.php");

function isEmailExists($email)
{
	global $connection;

	$query = "Select admin_id from admin Where email='$email'";

	$result = mysqli_query($connection, $query);

	if (mysqli_num_rows($result) == 1)
		return true;
	return false;
}

function isPhoneExists($phoneNo)
{
	global $connection;

	$query = "Select admin_id from admin Where phone_no=$phoneNo";

	$result = mysqli_query($connection, $query);

	if (mysqli_num_rows($result) == 1)
		return true;
	return false;
}

function getCurrentPageUrl(){
	$url = "";
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
           $url = "https://";   
    else  
           $url = "http://";  

    $url .=  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    return $url;
}

?>