<?php 
    require_once('../connection.php');

    $userId = $_POST['userId'];
    $productId = $_POST['productId'];
    $rate = $_POST['rate'];

    $query = "INSERT INTO feedback(user_id,product_id,rating) VALUES ($userId,$productId,$rate)";

    $result = mysqli_query($connection,$query);

    if($result == true)
      echo 1;
    else
      echo 0;
?>