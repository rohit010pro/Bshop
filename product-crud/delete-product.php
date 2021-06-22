<?php
session_start();
require_once('../connection.php');

$userId = $_SESSION['user-id'];  // User Id
$productId = $_POST['product_Id'];  // Product ID

$query = "Delete from cart_detail where product_id=$productId AND user_id=$userId";
$result = mysqli_query($connection,$query);

if($result === true)
    echo 1;
else
    echo 0;
?>