<?php
require("header.php");

if(isset($_SESSION['user-id']) == false)
    header('Location: auth-user/login.php');

$userId = $_SESSION['user-id'];
$productId = $productId;

// Insert or update user rating
if (isset($_POST['rate-button'])) {
    $rate = $_POST['rate'];
    $message = $_POST['rate-msg'];

    $userQ = "SELECT * FROM feedback WHERE user_id = $userId AND product_id = $productId";
    $userR = mysqli_query($connection,$userQ);

    if(mysqli_num_rows($userR) == 1){
        $queryI = "UPDATE feedback 
                SET rating = $rate, message = '$message' 
                WHERE user_id = $userId AND product_id = $productId";
    }else{
        $queryI = "INSERT INTO feedback(user_id,product_id,rating,message) 
           VALUES($userId,$productId,$rate,'$message')";
    }
    $resultI = mysqli_query($connection, $queryI) or die("Query Failed");

    header("Location: product-rate.php?pid=$productId");
}
?>

    <section id="rate-product" style="margin-top: 20px;">
        <div class="container">
            <?php
            $queryF = "SELECT * FROM products WHERE id = $productId";
            $resultF = mysqli_query($connection, $queryF);
            $rowF = mysqli_fetch_assoc($resultF);
            ?>
            <h1 class="sub-heading"><?php echo $rowF['name']; ?></h1>
            <div class="product-wrapper">

                <div class="product-image">
                    <img src="<?php echo $rowF['img_url']; ?>" alt="">
                </div>

                <div class="rating-part">
                    <!-- Rating Part START -->
                    <div class="rating-wrapper">
                        <?php
                        $productId = $productId;
                        $queryF = "SELECT product_id FROM feedback WHERE product_id = $productId";
                        $resultF = mysqli_query($connection, $queryF);
                        ?>
                            <?php
                            $queryR = "SELECT AVG(rating) as average,COUNT(user_id) as totaluser from feedback WHERE product_id = $productId";
                            $resultR = mysqli_query($connection, $queryR);
                            $rowR = mysqli_fetch_assoc($resultR);
                            $average = round($rowR['average'], 1);
                            $starPercentage = $average / 5 * 100;
                            ?>

                            <div class="rating-content">
                                <div class="rating-total">
                                    <span><?php echo $average; ?></span><i class="fa fa-star"></i>
                                    <div class="show-stars-wrapper">
                                        <div style="width: <?php echo $starPercentage; ?>%;" class="show-stars-inner"></div>
                                    </div>
                                    <p><?php echo $rowR['totaluser']; ?> Ratings</p>
                                    <?php
                                    // Checking is user buy this product or not
                                    $queryIB = "SELECT id FROM order_detail WHERE user_id = $userId AND product_id = $productId";
                                    $resultIB = mysqli_query($connection,$queryIB);
                                    $isBuy = (mysqli_num_rows($resultIB) > 0) ? 1 : 0;  
                                    ?>
                                    <button class="popup-trigger button" data-buy="<?php echo $isBuy; ?>">Add Review</button>
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
                    <!-- / Rating Part END -->
                </div>
            </div>
        </div>
    </section>

    <!-- Rating Popup Box -->
    <div id="user-rating" class="popup-box">
        <div class="popup-close">&times;</div>
        <?php
            $userQ = "SELECT * FROM feedback WHERE user_id = $userId AND product_id = $productId";
            $userR = mysqli_query($connection,$userQ);
            $userRow = mysqli_fetch_assoc($userR); 
        ?>
        <div class="rate-stars-wrapper" data-rated-star="<?php echo $userRow['rating'];?>">
            <span class="star" data-star="1"><i class="fa fa-star"></i></span>
            <span class="star" data-star="2"><i class="fa fa-star"></i></span>
            <span class="star" data-star="3"><i class="fa fa-star"></i></span>
            <span class="star" data-star="4"><i class="fa fa-star"></i></span>
            <span class="star" data-star="5"><i class="fa fa-star"></i></span>
        </div>
        <form action="#" method="POST" id="rate-form">
            <input type="hidden" id="rate" name="rate" value="0">
            <textarea name="rate-msg" rows="5" placeholder="Your review"><?php echo (empty($userRow['message']) ? "" : $userRow['message']);?></textarea>
            <button id="rate-btn" name="rate-button" type="submit">Rate</button>
        </form>
    </div>
    <!-- / Rating Popup Box -->

    <!-- Toast -->
    <div class="toast">
      <span class="icon"><i class="fa fa-exclamation-triangle"></i></span>
      <span class="msg">You have not buy this product. so you are not eligble to rate this product.</span>
      <span class="close">&times;</span>
    </div>
    <!-- / Toast -->

    <section id="product-review">

        <div class="container">
            <h1 class="sub-heading">User Reviews</h1>
            <?php
            $query = "SELECT f.rating,f.message,u.name FROM feedback f JOIN users u 
                        ON f.user_id = u.user_id
                        WHERE f.product_id = $productId
                        ORDER BY f.rating DESC LIMIT 10;";

            $result = mysqli_query($connection, $query) or die("Query Failed");

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="user-review">

                        <div class="user-name-pic">
                            <div class="profile-pic">
                                <img src="assets/images/user-logo-2.jfif" alt="">
                            </div>
                            <h4><?php echo $row['name']; ?></h4>
                        </div>

                        <div class="rating-wrapper">
                            <div class="show-stars-wrapper">
                                <?php $ratePer = $row['rating'] / 5 * 100;?>
                                <div style="width: <?php echo $ratePer; ?>%;" class="show-stars-inner"></div>
                            </div>
                        </div>

                        <p><?php echo $row['message']; ?></p>
                    </div>
            <?php
                }
            } else {
                echo "No Reviews";
            } ?>
        </div>
    </section>

    <div class="overlay"></div>

<?php
require("footer.php");
?>