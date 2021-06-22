<?php
session_start();
require_once("connection.php");

if(!isset($_SESSION['user-id']) || !isset($_SESSION['order-ref']))
    header("Location: error-pages/403.php");

$userId = $_SESSION['user-id'];

// Fetching Details
$orderRef = $_SESSION['order-ref'];

$query = "SELECT u.name, u.email, od.contact_no, SUM(od.sell_price * od.order_quantity) as total_price 
                FROM order_detail od JOIN users u 
                ON od.user_id = u.user_id WHERE order_ref = $orderRef";

$result = mysqli_query($connection,$query) or die("Fetch Query Failed");

$row = mysqli_fetch_assoc($result);

$name = $row['name'];
$email = $row['email'];
$contactNo = $row['contact_no'];
$totalPrice = $row['total_price'];

// ### Instamojo Payment Gatway Code

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("",
                  ""));
$payload = Array(
    'purpose' => "Buying Product",
    'amount' => $totalPrice,
    // 'phone' => $contactNo,
    'buyer_name' => $name,
    'redirect_url' => 'http://localhost/bshop/payment-status.php',
    'send_email' => true,
    // 'send_sms' => true,
    'email' => $email,
    'allow_repeated_payments' => false
);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
$response = curl_exec($ch);
curl_close($ch); 

$response = json_decode($response);

// echo "<pre>";
// print_r($response);

$txnId = $response->payment_request->id;    // Payment Request ID or Transcation ID
$payUrl = $response->payment_request->longurl;   // Payment URL
$totalAmount = $response->payment_request->amount;
$paymentStatus = $response->payment_request->status;

$_SESSION['transaction_id'] = $txnId;

$query = "INSERT INTO payment(txn_id, user_id, total_amount, payment_status)
          VALUES('$txnId', $userId, $totalAmount, '$paymentStatus')";

$result = mysqli_query($connection,$query) or die("Query Failed");

header("Location: ". $payUrl);
?>
