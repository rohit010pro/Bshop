<?php

$hostName = "localhost"; 	// Host Name of Mysql
$user     = "root";		    // Mysql User Name	
$password = "";				// Mysq User Password
$dbName   = "bshop";     	// Databases Name
 
// Connection
$connection = mysqli_connect($hostName, $user, $password, $dbName);
?>
