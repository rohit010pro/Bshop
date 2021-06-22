<?php
if (basename($_SERVER['PHP_SELF']) == "footer.php")
  header("Location: error-pages/403.php");
?>
<!-- SUGGESTION SECTION START -->

<section id="suggestion-section" class="products-slider">
  <!-- User's Browsing History -->
  <?php
  if (isset($_COOKIE['viewed_products']) && isset($_SESSION['user-id'])) {
  ?>
    <div class="container" id="suggestion">
      <h1 class="sub-heading">Inspired by your browing</h1>
      <div class="owl-carousel owl-theme">

        <?php
        require_once("connection.php");
        $arr = unserialize($_COOKIE['viewed_products']);
        for ($i = count($arr) - 1; $i >= 0; $i--) {
          $query = "Select id, name, price, img_url from products where id = $arr[$i]";

          $result = mysqli_query($connection, $query) or die("Fetch Query Failed");

          if ($row = mysqli_fetch_array($result)) { ?>

            <div class="item">
              <a href="product-details.php?id=<?php echo $row['id']; ?>">
                <img src="<?php echo $row['img_url']; ?>">
                <h4 class="brand"> <?php echo $row['name']; ?> </h4>
                <p class="price">&#8377; <?php echo $row['price']; ?></p>

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
                </div>
                <!-- / Rating Part END -->
              </a>
            </div>

        <?php }
        } ?>
      </div>
    </div>
    <?php } else {
    if (isset($_SESSION['user-id']) == false) {
    ?>
      <div style="text-align: center; padding: 30px; border-top: 1px solid #bbbbbb;">
        <h2 style="margin-bottom: 20px;">Sign In to see your suggestions</h2>
        <a href="auth-user/login.php" class="btn">Sign in</a>
      </div>
  <?php }
  } ?>
</section>

<!-- SUGGESTION SECTION START -->



<!--  FOOTER START -->
<footer id="footer">
  <div class="wrapper">
    <div class="list-container">

      <div class="list-box">
        <h1>Get to Know Us</h1>
        <ul>
          <li>About Us</li>
          <li>Story</li>
        </ul>
      </div>

      <div class="list-box">
        <h1>Social</h1>
        <ul class="social-links">
          <li><a href="#"><i class="fab fa-facebook"></i><span>Facebook</span></a></li>
          <li><a href="#"><i class="fab fa-instagram"></i><span>Instagram</span></a></li>
          <li><a href="#"><i class="fab fa-twitter"></i><span>Twitter</span></a></li>
        </ul>
      </div>

      <div class="list-box">
        <h1>Help</h1>
        <ul>
          <li>Payment</li>
          <li>Shipping</li>
          <li>Cancellation & Returns</li>
          <li>FAQs</li>
        </ul>
      </div>

      <div class="list-box">
        <h1>Contact Us</h1>
        <ul>
          <li>
              <a href="tel:<?php echo $siteInfo['phone_no']; ?>">
                <i class="fas fa-phone"></i><span><?php echo $siteInfo['phone_no']; ?></span>
              </a>
          </li>
          <li>
              <a href="mailto:<?php echo $siteInfo['email']; ?>">
                <i class="fas fa-envelope"></i><span><?php echo $siteInfo['email']; ?></span>
              </a>
          </li>
          <li>
            <i class="fas fa-map-marker-alt"></i>
            <span><?php echo $siteInfo['address']; ?></span>
          </li>
        </ul>
      </div>

    </div>

  </div>
  <div class="copyright">
    <p><?php echo $siteInfo['copyright']; ?></p>
  </div>

</footer>
<!--  FOOTER END -->


<!-- Jquery JS -->
<script src="assets/js/jquery.min.js"></script>
<!-- Owl carousel JS -->
<script src="assets/js/owl.carousel.min.js"></script>
<!-- Zoom JS -->
<script src="assets/js/exzoom.js"></script>
<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<!-- Ajax Cart -->
<script src="assets/js/ajax-cart.js"></script>
<!-- Rating -->
<script src="assets/js/rating.js"></script>

</body>

</html>