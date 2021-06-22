<!-- ###   Functions for Front Panel  ### -->

<?php
require_once("connection.php");

function getCurrentPageUrl(){
	$url = "";
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
           $url = "https://";   
    else  
           $url = "http://";  

    $url .=  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    return $url;
}

// Generate Order Reference
function orderRefGenerator(){
	date_default_timezone_set("Asia/Kolkata");
	$date = date("ymdHimsw");
	$randNum = rand(0,9);
	$orderRef = $date.$randNum;
	return $orderRef;
}

// Return the Product Name according to ID passed
function getProductName($id){
  global $connection;

  if ($id == "" || !is_numeric($id))
    header("Location: ./");

  $query = "Select name from products where id = $id";
  $result = mysqli_query($connection, $query);
  
  if(mysqli_num_rows($result) == 0)
    header("Location: error-pages/404.php");

  $row = mysqli_fetch_array($result);
  
  return $row['name'];
}

function getSiteInfo(){
  global $connection;
  $query = "SELECT * FROM site_settings";
  $result = mysqli_query($connection, $query);
  
  $siteInfo = mysqli_fetch_assoc($result);
  return $siteInfo;
}

function maxQuantity($productId){
  global $connection;
  $query = "SELECT quantity FROM products WHERE id = $productId";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);

  $maxQty = 10;
  if($row['quantity'] < $maxQty)
        $maxQty = $row['quantity'];

  return $maxQty;   
}
?>