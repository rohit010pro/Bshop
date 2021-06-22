<?php
session_start();

if(!isset($_SESSION['transaction_id']))
    header("Location: error-pages/403.php");

require_once("connection.php");
require_once("function.php");

$siteInfo = getSiteInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $siteInfo['title_logo'];?>" type="image/gif">
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/payment.css">
    <title>Payment Status</title>
</head>
<body>

    <section id="payment-result" class="card-container">
        <div class="card">
            <?php
            if ($_SESSION['transaction_id'] == $_REQUEST['payment_request_id'] &&
                $_REQUEST['payment_status'] == "Credit") {
                    $userId = $_SESSION['user-id']; 
                    $txnId = $_SESSION['transaction_id'];
                    $query = "UPDATE payment SET payment_status = 'Credit' WHERE txn_id = '$txnId'";
                    $result = mysqli_query($connection,$query) or die("Payment Status Update Failed");

                    // Fetching Payment Details
                    $query = "SELECT * FROM payment WHERE txn_id = '$txnId'";
                    $result = mysqli_query($connection,$query) or die("Select Query Failed");
                    $row = mysqli_fetch_assoc($result);
            ?>
                <div class="content">
                    <h2 class="title success">Payment Successful</h2>
                    <div class="payment-details">
                        <table>
                            <tr>
                                <td>Payment ID</td>
                                <td><?php echo $_REQUEST['payment_id']; ?></td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td><?php echo $row['total_amount']; ?></td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td><?php echo $row['payment_status']; ?></td>
                            </tr>
                            <tr>
                                <td>Paid For</td>
                                <td>Buy Product</td>
                            </tr>
                            <tr>
                                <td>Paid To</td>
                                <td>Rohit Kanojiya</td>
                            </tr>
                        </table>
                    </div>
                    <a href="./" class="btn">Continue Shopping</a>
                </div>
            <?php 
            $orderRef = $_SESSION['order-ref'];
            $paymentId = $row['payment_id']; 
            $query = "UPDATE order_detail SET payment_id = $paymentId, payment_status = 'paid'  
                    WHERE order_ref = $orderRef";
            $result = mysqli_query($connection,$query) or die("Update Query Failed");
            
            // Single Product
            if(isset($_SESSION['single-product']) && $_SESSION['single-product'] == 1){
                $query = "SELECT p.id, od.order_quantity FROM order_detail od JOIN products p
                            ON od.product_id = p.id
                            WHERE od.order_ref = $orderRef";
                $result = mysqli_query($connection, $query);

                $row = mysqli_fetch_assoc($result);
                
                $productId = $row['id'];
                $productOrderQty = $row['order_quantity'];

                $query = "UPDATE products SET quantity = quantity-$productOrderQty WHERE id = $productId";
                $result = mysqli_query($connection, $query) or die("Single Product query Failed");
            }
            else{
                    // Updating Products Quantity of Cart Purchase
                    $query = "SELECT cd.product_id,cd.quantity,p.price FROM
                             cart_detail cd INNER JOIN products p ON cd.product_id = p.id 
                             WHERE cd.user_id = $userId";

                    $result = mysqli_query($connection,$query) or die("Fetch Query Failed");

                    $query = "";
                    while ($row = mysqli_fetch_assoc($result)) {   
                        $query .= "UPDATE products SET quantity = quantity-{$row['quantity']} 
                                    WHERE id = {$row['product_id']};";
                    }
                    $result = mysqli_multi_query($connection,$query) or die("All Query Failed: ". mysqli_error($connection));
                }
                header("Location: orders.php");
            }   
            // Payment Failed 
            else { 
            ?>
                <div class="content">
                    <h2 class="title error">Payment Unsuccessful</h2>
                    <h3 class="sub-title error">Some Error Occured</h3>
                    <a href="./" class="btn">Continue Shopping</a>
                </div>
            <?php } ?>
        </div>
    </section>

</body>

</html>