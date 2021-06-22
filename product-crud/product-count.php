<?php
 require_once('../connection.php');
 
session_start();
if(isset($_SESSION['user-id'])){
    $userId = $_SESSION['user-id'];

    $query = "SELECT id from cart_detail WHERE user_id = $userId";

    $result = mysqli_query($connection, $query);

    $cartProduct = mysqli_num_rows($result);

    echo $cartProduct;
}else{
    // echo '<span style="color:#fff">!</span>';
    echo "!";
}
?>