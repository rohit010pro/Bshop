<?php
session_start();
require_once('../connection.php');

$userId = $_SESSION['user-id'];

$query = "SELECT p.name,p.brand,p.price,p.img_url,cd.product_id,cd.quantity
          FROM cart_detail cd
          INNER JOIN products p
          ON cd.product_id = p.id
          where cd.user_id = $userId";

$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) == 0) {
    echo 0;
} else {

    $output = '<div id="products-wrapper">
    <input type="hidden" name="cart-product" value="true">';

    $subTotalAllProduct = 0;
    $products = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $subTotalPerProduct = $row['price'] * $row['quantity'];
        $subTotalAllProduct += $subTotalPerProduct;
        $products += $row['quantity'];
     
        $maxQty = maxQuantity($row['product_id']);

        $output = $output . <<< EOT
        <div class="product">
            <div class="product-img">
                <a href="product-details.php?id={$row['product_id']}">
                <img src="{$row['img_url']}"/></a>
            </div>                                                
            <div class="product-details">
                <p class="name">{$row['name']}</p>
                <p class="net-price">&#8377;<span class="pv">{$row['price']}</span></p>
                <div class="user-options">
                    <div class="quantity-wrapper">
                        <span class="minus">&minus;</span>
                        <input class="quantity" type="number" name="quantity" value="{$row['quantity']}" 
                        min="1" max="{$maxQty}" data-pid="{$row['product_id']}"/>
                        <span class="plus">&plus;</span>
                    </div>
                    <span class="seperator">|</span>
                    <button class="delete-btn popup-trigger" type="button" data-pid="{$row['product_id']}">Delete</button>
                </div>
            </div>
            <div class="sub-total">&#8377;<span class="p">{$subTotalPerProduct}</span></div>
        </div>
        EOT;
    }
    $output = $output . "</div>";

    $output = $output  . <<< "EOT"
        <div id="products-total">
            <div class="head-title">
                <p>PRICE DETAILS</p>
            </div>
            <div class="price">
                <p class="type">Price({$products} item)</p>
                <p class="p">&#8377;<span>{$subTotalAllProduct}</span></p>
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
                <p>&#8377;<span>{$subTotalAllProduct}</span></p>
            </div>
            <div class="action">
                <a class="btn" href="purchase-details.php?fromcartpage=true">Proceed to Buy</a>
            </div>
        </div>
        EOT;

    echo $output;
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
