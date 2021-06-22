<?php
require_once("header.php");
require_once("connection.php");

$subCateId = $subCateId;

$query = "SELECT id, name, brand, price, description, img_url FROM 
            products WHERE sub_cate_id = $subCateId";

$result = mysqli_query($connection, $query) or die("Fetch Query Failed");
?>

<section id="search-products">
    <div class="container">
        
        <h1 style="margin-bottom: 50px;">Category: 
            <?php echo (isset($subCateName) ? $subCateName : ""); ?>
        </h1>

        <div id="product-wrapper">

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <!-- Product -->
                    <div class="product">
                        <div class="product-image">
                            <a href="product-details.php?id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['img_url']; ?>" alt="">
                            </a>
                        </div>
                        <div class="product-details">
                            <div>
                                <div class="product-name">
                                    <h3>
                                        <a href="product-details.php?id=<?php echo $row['id']; ?>">
                                            <?php echo $row['name']; ?>
                                        </a>
                                    </h3>
                                </div>
                                <div class="product-brand"><?php echo $row['brand']; ?></div>
                            </div>

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

                            <div class="product-description">
                                <?php echo $row['description']; ?>
                            </div>
                            <div class="product-price">&#8377;<?php echo $row['price']; ?></div>
                        </div>
                    </div>
                    <!-- / Product -->

                <?php }
            } else { ?>
                <div style="height: 300px; text-align:center; padding:100px 0;">
                    <h1 style="padding-bottom:50px;">No Products Found</h1>
                </div>
            <?php } ?>
        </div>
    </div>
</section>


<!-- Including Footer Section -->
<?php require("footer.php"); ?>