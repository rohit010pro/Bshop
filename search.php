<?php
require_once("header.php");
require_once("connection.php");

$search = $search;

$query = "SELECT p.id,p.name,p.brand,p.price,p.description,p.img_url,c.name cname,sc.name scname FROM products p 
            JOIN category c
            ON p.cate_id = c.id
            JOIN sub_category sc
            ON p.sub_cate_id = sc.id
            WHERE p.name LIKE '%$search%'
            OR p.brand LIKE '%$search%'
            OR p.price LIKE '%$search%'
            OR p.description LIKE '%$search%'
            OR c.name LIKE '%$search%' 
            OR sc.name LIKE '%$search%'";

$result = mysqli_query($connection, $query);
?>

<section id="search-products">
    <div class="container">
        <h1 style="margin-bottom: 50px;">Search: <?php echo $search; ?></h1>
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
                <div class="stop-box" style="background-image:url('assets/images/error-no-search-results.png');">
                </div>
            <?php } ?>
        </div>
    </div>
</section>


<!-- Including Footer Section -->
<?php require("footer.php"); ?>