<?php
	session_start();
	require_once("function.php");
	require_once("connection.php");

	if (isset($_SESSION['access_token']))
		$google_client->setAccessToken($_SESSION['access_token']);
	else if (isset($_GET['code'])) 
	{
		$token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['access_token'] = $token;
	} else {
		header('Location: login.php');
	}

	$oAuth = new Google_Service_Oauth2($google_client);
    
	$userData = $oAuth->userinfo_v2_me->get();

	// User Data
	$authUId = $userData['id'];
 	$fullName = $userData['name'];
	$email = $userData['email'];

	// Checking if User Email Already Exists
	if(isEmailExists($email) == false){
		$query = "INSERT INTO users(name, email, auth_uid, auth_brand) VALUES 
				 ('$fullName', '$email', '$authUId', 'google')";

		$result = mysqli_query($connection, $query) or die("Insert Query Failed");
	}

	$query = "SELECT user_id,name FROM users WHERE email = '$email' AND auth_uid = '$authUId'";
	
	$result = mysqli_query($connection, $query) or die("Fetch Query Failed");

	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		$_SESSION['user-id'] = $row['user_id'];
		$_SESSION['user-name'] = $row['name'];
		header("Location: ../");
	}

?>
