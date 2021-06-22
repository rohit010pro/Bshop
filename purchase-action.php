<?php
session_start();
 
if(isset($_SESSION['user-id']) == false)
    header('Location: login.php');

if(!isset($_POST['single-product']) || !isset($_POST['cart-product'] ))
	header("Location: error-pages/403.php");

require_once('connection.php');		
require_once('function.php');	

 $userId = $_SESSION['user-id'];

 $contactNo = $_POST['contact-no']; 

// Address
 $address = $_POST['house'] ."|". $_POST['area'] ."|". $_POST['landmark'];
 
 $pinCode = $_POST['pin-code'];
 $city = $_POST['city'];
 $state = $_POST['state'];
 $country = $_POST['country'];

 $orderRef = orderRefGenerator();


// Creating queries
 	$paymentStatus = "pending";
 	if(isset($_POST['payment-mode']) && $_POST['payment-mode'] == "cod"){
 		$paymentStatus = "cod";
	}

	$query = "";
	// For Single Product
	if(isset($_POST['single-product']) && $_POST['single-product'] == "true"){
		$productId = $_POST['product-id'];
		$quantity = $_POST['quantity'];
		$sellPrice = $_POST['net-price'];

		$query .= "INSERT INTO order_detail(order_ref, user_id, product_id, sell_price,order_quantity,contact_no,address,city,state,pin_code,country,payment_status) 
 VALUES($orderRef ,$userId, $productId, $sellPrice, $quantity,$contactNo,'$address','$city','$state',$pinCode,'$country','$paymentStatus');";

 		if($paymentStatus == "cod"){
 			$queryUpdate = "UPDATE products SET quantity = quantity-$quantity WHERE id = $productId";
 			$resultUpdate = mysqli_query($connection, $queryUpdate) or die("Single Update query Failed");
 		}else{
 			$_SESSION['single-product'] = 1;
 		}
	}

	// For Multiple(Cart) Product
	else if(isset($_POST['cart-product']) && $_POST['cart-product'] == "true"){

		$queryC = "SELECT cd.product_id,cd.quantity,p.price FROM
	         cart_detail cd INNER JOIN products p ON cd.product_id = p.id 
	         WHERE cd.user_id = $userId";

		$resultC = mysqli_query($connection,$queryC);

		while ($row = mysqli_fetch_assoc($resultC)) {	
			 $query .= "INSERT INTO order_detail(order_ref, user_id, product_id, sell_price, order_quantity,contact_no,address,city,state,pin_code,country,payment_status) 
			 VALUES($orderRef ,$userId, {$row['product_id']}, {$row['price']}, {$row['quantity']},$contactNo,'$address','$city','$state',$pinCode,'$country','$paymentStatus');";

			 if($paymentStatus == "cod")
			 $query .= "UPDATE products SET quantity = quantity-{$row['quantity']} 
                        WHERE id = {$row['product_id']};";
		}
	}


// If User's First Order inserting address to users table
 $queryU = "SELECT * FROM users WHERE user_id = $userId";
 $resultU = mysqli_query($connection,$queryU) or die("User Query Failed");
 $rowU = mysqli_fetch_assoc($resultU);

 if($rowU['address'] == null)
 {
 $query .= "UPDATE users SET 
 			address='$address', 
 			city = '$city',
 			state = '$state',
 			pin_code = $pinCode,
 			country = '$country'
 			WHERE user_id =  $userId;";		    
}

$result = mysqli_multi_query($connection,$query) or die("All Query Failed". mysqli_error($connection));

if(isset($_POST['payment-mode']) && $_POST['payment-mode'] == "cod"){
	header("Location: orders.php");
}else{

 $_SESSION['order-ref'] = $orderRef;
 header("Location: instamojo.php");
}

?>