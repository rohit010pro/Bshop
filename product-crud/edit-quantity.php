<?php
session_start();
require_once('../connection.php');

 $userId = $_SESSION['user-id'];  // User Id
 $productId = $_POST['product_Id'];  // Product ID
 $currentQuantity = $_POST['quantity']; // Input Quantity

   if($currentQuantity <= maxQuantity($productId)){
      $query = "UPDATE cart_detail set quantity = $currentQuantity 
               WHERE user_id=$userId AND product_id=$productId";
         
      $result = mysqli_query($connection, $query) or die("Update Quantity Failed");
      echo 1;
   }else{
      echo 0;
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