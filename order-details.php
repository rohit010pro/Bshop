<?php 
require_once("header.php");

if(isset($_SESSION['user-id']) == false)
    header('Location: auth-user/login.php');

$userId = $_SESSION['user-id'];
$productId = $productId;
?>
<section id="order-details-section" class="one-product-details">
    <div class="container">
        <h1 class="sub-heading">Ordered Product Detail</h1>
        <div class="product-wrapper">
            <?php
            $query = "SELECT * FROM order_detail od
                      JOIN products p ON od.product_id = p.id
                      WHERE od.user_id = $userId AND od.product_id = $productId";
            $result = mysqli_query($connection, $query);

            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="product-img">
                <!-- <img src="uploads/electronics/mobiles/poco-c3.jpeg" class="product-image"> -->
                <div class="exzoom" id="exzoom">
                    <!-- Images -->
                    <div class="exzoom_img_box">
                        <ul class="exzoom_img_ul">
                            <li>
                                <img src="<?php echo $row['img_url']; ?>" />
                            </li>
                            <li>
                                <img src="<?php echo $row['img_url']; ?>" />
                            </li>
                            <li>
                                <img src="<?php echo $row['img_url']; ?>" />
                            </li>
                            <li>
                                <img src="<?php echo $row['img_url']; ?>" />
                            </li>
                            <li>
                                <img src="<?php echo $row['img_url']; ?>" />
                            </li>
                            ...
                        </ul>
                    </div>
                    <!-- <a href="https://www.jqueryscript.net/tags.php?/Thumbnail/">Thumbnail</a> Nav-->
                    <div class="exzoom_nav"></div>
                    <!-- Nav Buttons -->
                    <p class="exzoom_btn">
                        <a href="javascript:void(0);" class="exzoom_prev_btn"> &lt; </a>
                        <a href="javascript:void(0);" class="exzoom_next_btn"> &gt; </a>
                    </p>
                </div>
            </div>

            <div class="product-details">
                <h2 class="name"><?php echo $row['name']; ?></h2>
                <p class="brand"><?php echo $row['brand']; ?></p>

                <!-- Rating Part START -->
                <div class="rating-wrapper">
                    <?php
                    $productId = $row['id'];
                    $queryF = "SELECT product_id FROM feedback WHERE product_id = $productId";
                    $resultF = mysqli_query($connection, $queryF);

                        $queryR = "SELECT AVG(rating) as average, COUNT(user_id) as totaluser from feedback WHERE product_id = $productId AND rating != 0";
                        $resultR = mysqli_query($connection, $queryR);
                        $rowR = mysqli_fetch_assoc($resultR);

                        $average = round($rowR['average'], 1);
                        $starPercentage = $average / 5 * 100;
                        $starPercentageRounded = round($starPercentage / 10) * 10;

                    ?>
                        <div class="show-stars-wrapper">
                            <div style="width: <?php echo $starPercentageRounded; ?>%;" class="show-stars-inner"></div>
                        </div>
                        <?php
                            $reviewQ = "SELECT COUNT(user_ID) as totalreview from feedback WHERE product_id = $productId AND message != ''";
                            $reviewR = mysqli_query($connection,$reviewQ);
                            $reviewRow = mysqli_fetch_assoc($reviewR);
                        ?>

                        <div class="showNumRating">
                            <a href="product-rate.php?pid=<?php echo $row['id'];?>">
                            <?php echo "(".$rowR['totaluser'] . " ratings & " .$reviewRow['totalreview'] . " reviews)"; ?>
                            </a>
                        </div>

                        <div class="rating-dropdown">
                            <div class="rating-content">
                                <div class="rating-total">
                                    <span><?php echo $average; ?></span><i class="fa fa-star"></i>
                                    <p><?php echo $rowR['totaluser']; ?> Ratings</p>
                                </div>
                                <div class="rating-state">
                                    <?php
                                    for ($i = 5; $i > 0; $i--) {
                                        $queryS = "SELECT COUNT(user_id) as totaluser from feedback WHERE product_id = $productId AND rating = $i";
                                        $resultS = mysqli_query($connection, $queryS);
                                        $rowS = mysqli_fetch_assoc($resultS);

                                        if(!empty($rowS['totaluser']) && !empty($rowR['totaluser']))    
                                         $perPerStar = ($rowS['totaluser'] / $rowR['totaluser']) * 100;
                                        else
                                         $perPerStar = 0;   
                                    ?>
                                        <div class="single-star-rating">
                                            <div class="title"><span><?php echo $i; ?></span><i class="fa fa-star"></i></div>
                                            <div class="progress-bar">
                                                <div class="value" style="width: <?php echo $perPerStar; ?>%;"></div>
                                            </div>
                                            <div class="ratings"><?php echo $rowS['totaluser']; ?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- / Rating Part END -->

                <p class="description"><?php echo $row['description']; ?></p>
                <p class="price">&#8377;<?php echo $row['sell_price']; ?></p>

                <div class="order-details">
                    <p><span>Order ref: </span>#<?php echo $row['order_ref']; ?></p>
                    <p><span>Order placed: </span>
                        <?php
                        $timeStamp = strtotime($row['order_date']);
                        echo date("d M Y", $timeStamp); ?>
                    </p>
                    <p><span>Qty: </span> <?php echo $row['order_quantity']; ?></p>
                    <p><span>Mobile no: </span><?php echo $row['contact_no']; ?></p>
                    <p><span>Address: </span><?php echo $row['address'] . " [" . $row['pin_code'] . "]"; ?></p>
                    <p><span>City: </span><?php echo $row['city']; ?></p>
                    <p><span>State: </span><?php echo $row['state']; ?></p>
                    <p><span>Status: </span><?php echo $row['status']; ?></p>
                    <p class="total"><span>Total: </span> &#8377;<?php echo ($row['order_quantity'] * $row['sell_price']); ?></p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require("footer.php"); ?>