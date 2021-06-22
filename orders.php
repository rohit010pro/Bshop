<!-- Including Header Section -->
<?php require("header.php"); 

if(isset($_SESSION['user-id']) == false)
    header('Location: auth-user/login.php');

  $userId = $_SESSION['user-id'];
?>

<section id="order-section">
    <div class="container">
        <h1 class="sub-heading">Your Orders</h1>
        <?php
        $query = "SELECT * FROM order_detail od
                    JOIN products p ON od.product_id = p.id
                    WHERE user_id = $userId";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
        ?>
            <div id="db-products">

                <div id="products-wrapper">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <!-- Product -->
                        <div class="product">
                            <div class="product-desc">
                                <div class="product-img">
                                    <a href="product-details.php?id=<?php echo $row['product_id']; ?>">
                                        <img src="<?php echo $row['img_url']; ?>" /></a>
                                </div>
                                <div class="product-details">
                                    <p class="name"><?php echo $row['name']; ?></p>
                                    <p class="net-price">&#8377;<span class="pv"><?php echo $row['sell_price']; ?></span></p>
                                    <div class="user-options">
                                        <div class="quantity-wrapper">
                                            <span>Qty: </span>
                                            <span><?php echo $row['order_quantity']; ?></span>
                                        </div>
                                        <!-- <span class="seperator">|</span>
                                        <button class="delete-btn" type="button">Cancel</button> -->
                                    </div>
                                </div>
                            </div>

                            <div class="order-desc">
                                <p>
                                    <span>Order ref:</span>
                                    <span>#<?php echo $row['order_ref']; ?></span>
                                </p>
                                <p>
                                    <span>Order placed:</span>
                                    <span><?php
                                            $timeStamp = strtotime($row['order_date']);
                                            echo date("d M Y", $timeStamp); ?></span>
                                </p>
                                <p><span>Total: &#8377;</span><span><?php echo ($row['order_quantity'] * $row['sell_price']); ?></span>
                                </p>
                                <p class="more-details"><a href="order-details.php?pid=<?php echo $row['product_id']; ?>">More details &#187;</a></p>
                            </div>

                        </div>
                        <!-- Product /-->
                    <?php } ?>
                </div>

            </div>

        <?php }else{?>

            <div class="stop-box">
              <div class="center">
                <h1>You have not placed any order</h1>
                <a href="./" class="btn">Shop Now</a>
              </div>
            </div>
            
        <?php } ?>
    </div>
</section>

<!-- Including Footer Section -->
<?php require("footer.php"); ?>
