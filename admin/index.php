<?php  
    require_once("connection.php");
	session_start();
    
    if(isset($_SESSION['admin-id']) == true)
    	header('Location: dashboard.php');
    else
    	header("Location: login.php");
?>