<?php
require_once("connection.php");

session_start();

if(isset($_SESSION['access_token']))
    $google_client->revokeToken();

session_unset();

session_destroy();

header("Location: ../");
?>