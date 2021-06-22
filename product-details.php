<?php
require_once("header.php");

$productId = $productId;

if (isset($_SESSION['user-id']))
    $userId = $_SESSION['user-id'];
else
    $userId = "";

$query = "Select id,name,brand,price,img_url,description from products where id = $productId";

$result = mysqli_query($connection, $query);

$row = mysqli_fetch_array($result);
?>

<!-- Product Detail Start-->
<section id="product-detail" class="one-product-details">
    <div class="container">
        <h1 class="sub-heading">Product Detail</h1>

        <div class="product-wrapper">

            <div class="product-img">

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
                    $reviewR = mysqli_query($connection, $reviewQ);
                    $reviewRow = mysqli_fetch_assoc($reviewR);
                    ?>

                    <div class="showNumRating">
                        <a href="product-rate.php?pid=<?php echo $row['id']; ?>">
                            <?php echo "(" . $rowR['totaluser'] . " ratings & " . $reviewRow['totalreview'] . " reviews)"; ?>
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

                                    if (!empty($rowS['totaluser']) && !empty($rowR['totaluser']))
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

                <div class="description"><?php echo $row['description']; ?></div>
                
                <p class="price">&#8377;<?php echo $row['price']; ?></p>

                <?php                    
                    $query = "SELECT quantity FROM products WHERE id = $productId";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $quantity = $row['quantity'];
                    if($quantity > 0){
                ?>
                <div class="buttons">
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                        <button type="submit" name="add-cart-btn" class="btn" >Add to Cart</button>
                    </form>
                    <?php
                    //If Add-to-Cart Button is Clicked and User Logged In
                    if (isset($_POST['add-cart-btn'])) {
                        if (isset($_SESSION['user-id'])) {
                            $userId = $_SESSION['user-id']; // Fetching Login User Id

                            $query = "Select quantity from cart_detail Where user_id = $userId AND product_id = $productId";
                            $result = mysqli_query($connection, $query);
                            
                            if (mysqli_num_rows($result) == 1) {                    
                            } else {
                                $query = "Insert Into cart_detail(product_id,user_id,quantity) VALUES 
                                        ($productId, $userId , 1)";
                                $result = mysqli_query($connection, $query) or die("Insert Query Failed");
                            }
                            header("Location: cart.php");                                
                        } else {
                            header("Location: auth-user/login.php");
                        }
                    }
                    ?>
                    <a class="btn" href="purchase-details.php?productId=<?php echo $productId; ?>">Buy Now</a>
                </div>
                <?php }else{
                    echo "<p class='notinstock'>Product not in stock</p>";
                }
                ?>
            </div>

        </div>

    </div>


</section>

<?php
$query = "SELECT sub_cate_id FROM products WHERE id = $productId ";

$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$subCatId = $row['sub_cate_id'];

?>
<section id="more-product" class="products-slider">
    <div class="container" id="more-product">
        <h1 class="sub-heading">More Products</h1>
        <div class="owl-carousel owl-theme">
            <?php
            $query = "Select id, name, price, img_url from products where sub_cate_id = $subCatId ORDER BY id DESC LIMIT 12";

            $result = mysqli_query($connection, $query) or die("Query Failed");

            while ($row = mysqli_fetch_array($result)) { ?>

                <div class="item">
                    <a href="product-details.php?id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $row['img_url']; ?>">
                        <h4 class="brand"> <?php echo $row['name']; ?> </h4>
                        <p class="price">&#8377; <?php echo $row['price']; ?></p>
                    </a>
                </div>

            <?php } ?>
        </div>
    </div>
</section>
<!-- Product Detail End-->

<!-- Storing User Viewed Products in Cookies -->
<?php
if (isset($_SESSION['user-id'])) {

    if (isset($_COOKIE['viewed_products'])) {

        $arr = unserialize($_COOKIE['viewed_products']);

        $newArr = array();
        foreach ($arr as $key => $value) {
            if ($value != $productId)
                $newArr[] = $value;
        }
        array_push($newArr, $productId);

        $data = serialize($newArr);
        setcookie("viewed_products", $data, time() + 60 * 60 * 24 * 30, "./");
    } else {

        $data = serialize(array($productId));
        setcookie("viewed_products", $data, time() + 60 * 60 * 24 * 30, "./");
    }
}
?>

<!-- Including Footer Section -->
<?php require("footer.php"); ?>