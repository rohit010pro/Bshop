<?php
// Connection file
require_once '../connection.php';

//Include Google Client Library for PHP autoload file
require_once 'google-login-api/vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId("11608267955-cdlkhfmioh770nsliddosefaec6ieuc0.apps.googleusercontent.com");

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret("7RjHUy8NoCSxOUi1frdeZGqp");

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/Bshop/auth-user/g-callback.php');

$google_client->setApplicationName("Bshop");

$google_client->addScope('https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email');

?>
