<?php
session_start();
require_once("connection.php");
require_once("function.php");

if (isset($_SESSION['user-id']) == false)
    header("Location: auth-user/login.php?redirect_url=".urlencode(getCurrentPageUrl()));

$userId = $_SESSION['user-id'];

if(isset($_REQUEST['fromcartpage'])){ 
    if($_REQUEST['fromcartpage'] != "true")
        header("Location: error-pages/404.php");
}
else if(isset($_REQUEST['productId'])){
    $productId = $_REQUEST['productId'];
    $pageTitle = getProductName($productId);
}else
    header("Location: error-pages/403.php");

$siteInfo = getSiteInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Detail</title>
    <link rel="icon" href="<?php echo $siteInfo['title_logo'];?>" type="image/gif">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/dp-products.css">
    <link rel="stylesheet" href="assets/css/purchase-detail.css">
    <style>
        #products-total .action {
            display: none;
        }

        .form-control {
            margin: 15px 0;
        }
    </style>
</head>

<body>

    <header>
        <div class="container">
            <a href="./">
                <img src="<?php echo $siteInfo['site_logo'];?>" style="height: 50px; width: 200px;" alt="<?php echo $siteInfo['name'];?>">
            </a>
        </div>
    </header>

    <section id="purchase-detail" style="margin-bottom: 400px;">
        <div class="container">
            <h1 class="sub-heading">Purchase Detail</h1>
            <form action="purchase-action.php" method="POST">
                <div id="db-products">
                    <!-- If Redirect from Cart page -->
                    <?php if (isset($_REQUEST['fromcartpage']) && $_REQUEST['fromcartpage'] == "true") 
                    {   }
                    /*  If Redirect from Product Page  */ 
                    else if (isset($_REQUEST['productId'])) {
                        $productId = $_REQUEST['productId'];
                        $query = "Select id,name,brand, price, img_url, description from products Where id = $productId";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                    ?>
                        <input type="hidden" name="single-product" value="true">
                        <input type="hidden" name="product-id" value="<?php echo $productId; ?>">
                        <div id="products-wrapper">

                            <div class="product">
                                <div class="product-img">
                                    <a href="product-details.php?id=<?php echo $row['id']; ?>">
                                        <img src="<?php echo $row['img_url']; ?>" /></a>
                                </div>
                                <div class="product-details">
                                    <p class="name"><?php echo $row['name']; ?></p>
                                    <p class="net-price">&#8377;<span class="pv"><?php echo $row['price']; ?></span></p>

                                    <input type="hidden" name="net-price" value="<?php echo $row['price']; ?>">
                                    <?php
                                        $maxQty = maxQuantity($row['id']);
                                        $maxQty = $maxQty < 10 ? $maxQty : 10;
                                    ?>
                                    <div class="user-options">
                                        <div class="quantity-wrapper">
                                            <span class="minus">&minus;</span>
                                            <input class="quantity" type="number" name="quantity" value="1" min="1" max="<?php echo $maxQty; ?>" />
                                            <span class="plus">&plus;</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sub-total">&#8377;<span class="p"><?php echo $row['price']; ?></span></div>
                            </div>

                        </div>
                        <div id="products-total">
                            <div class="head-title">
                                <p>PRICE DETAILS</p>
                            </div>
                            <div class="price">
                                <p class="type">Price (1 item)</p>
                                <p class="p">&#8377;<span><?php echo $row['price']; ?></span></p>
                            </div>
                            <div class="discount">
                                <p class="type">Discount</p>
                                <p class="p">&#8377;<span>0</span></p>
                            </div>
                            <div class="delivery-charge">
                                <p class="type">Delivery charges</p>
                                <p class="p">FREE</p>
                            </div>
                            <div class="total">
                                <p>Total Amount</p>
                                <p>&#8377;<span><?php echo $row['price']; ?></span></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div id="user-detail-wrapper">
                    <?php
                    $query = "SELECT * FROM users WHERE user_id = $userId";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <h1 style="margin-bottom: 30px;">User Detail:</h1>
                    <div class="input-field">
                        <label>Name</label>
                        <input name="name" type="text" disabled value="<?php echo $row['name']; ?>" />
                    </div>
                    <div class="input-field">
                        <label>Email</label>
                        <input name="email" type="text" disabled value="<?php echo $row['email']; ?>" />
                    </div>
                    <div class="input-field">
                        <label>Phone number</label>
                        <input name="contact-no" type="tel" required value="<?php echo $row['phone_no']; ?>" />
                    </div>
                    <div class="input-field">
                        <label>Pin code</label>
                        <input name="pin-code" type="number" required value="<?php echo $row['pin_code']; ?>" />
                    </div>
                    <?php
                    if (empty($row['address']))
                        $addressArr = array("", "", "");
                    else
                        $addressArr = explode("|", $row['address']);
                    ?>
                    <div class="input-field">
                        <label>Flat, House no., Building, Company, Apartment</label><br>
                        <input name="house" type="text" required value="<?php echo $addressArr[0]; ?>">
                    </div>
                    <div class="input-field">
                        <label>Area, Colony, Street, Sector, Village</label><br>
                        <input name="area" type="text" required value="<?php echo $addressArr[1]; ?>">
                    </div>
                    <div class="input-field">
                        <label>Landmark</label><br>
                        <input name="landmark" type="text" required value="<?php echo (isset($addressArr[2]) ? $addressArr[2] : ""); ?>">
                    </div>
                    <div class="input-field">
                        <label>City:</label>
                        <input name="city" type="text" required value="<?php echo $row['city']; ?>" />
                    </div>
                    <div class="input-field">
                        <label>State:</label>
                        <input name="state" type="text" required value="<?php echo $row['state']; ?>" />
                    </div>
                    <div class="input-field">
                        <label>Country:</label>
                        <input name="country" type="text" value="<?php echo $row['country']; ?>" />
                    </div>

                    <div class="small-input-group input-field" style="margin-top: 10px;">
                        <label class="block" style="margin-right: 15px;">Payment Mode:</label>
                        <label class="small-input-label" for="paynow">
                            <input type="radio" name="payment-mode" value="paynow" id="paynow" checked>Pay now
                        </label>
                        <label class="small-input-label" for="cod">
                            <input type="radio" name="payment-mode" value="cod" id="cod">COD(Cash on Delivery)
                        </label>
                    </div>
                    <br><br>

                    <input type="submit" class="button" name="buy-now" value="Order Now" style="margin-top: 10px;">
                </div>
            </form>
        </div>
        <div class="toast">
            <span class="icon"><i class="fa fa-exclamation-triangle"></i></span>
            <span class="msg">You have not buy this product. so you are not eligble to rate this product.</span>
            <span class="close">&times;</span>
        </div>
    </section>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/ajax-purchase-detail.js"></script>
</body>

</html>