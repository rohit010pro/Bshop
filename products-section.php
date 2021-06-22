<?php
if(basename($_SERVER['PHP_SELF']) == "products-section.php")
  header("Location: error-pages/403.php");
?>

<?php
require_once("connection.php");
?>
<!-- PRODUCTS SECTION START  -->
<section id="products-section" class="products-slider">

  <div style="background-color: #f1f1f1; padding: 5px 0 15px 0;">
    <!-- Today's Deal -->
    <div class="container" id="todays-deal">
      <h1 class="sub-heading">Today's Deal</h1>
      <div class="owl-carousel owl-theme">

        <?php
        $query = "Select id, name, price, img_url from products WHERE id > 2 LIMIT 12";
        $result = mysqli_query($connection, $query) or die("Query Failed");

        while ($row = mysqli_fetch_array($result)) { ?>

          <div class="item">
            <a href="product-details.php?id=<?php echo $row['id']; ?>">
              <img src="<?php echo $row['img_url']; ?>">
              <h4 class="brand"><?php echo $row['name']; ?></h4>
              <p class="price">&#8377;<?php echo $row['price']; ?></p>
            </a>
          </div>

        <?php } ?>

      </div>
    </div>
  </div>

  <!--  Mobiles -->
  <div class="container" id="mobiles">
    <h1 class="sub-heading">Latest Mobiles</h1>
    <div class="owl-carousel owl-theme">

      <?php
      $query = "Select id, name, price, img_url from products where sub_cate_id = 1 ORDER BY id DESC";

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

  <!-- Headphones -->
  <div class="container" id="watches">
    <h1 class="sub-heading">Best Headphones</h1>
    <div class="owl-carousel owl-theme">

      <?php
      $query = "Select id,name, price, img_url from products Where sub_cate_id = 4 ORDER BY id DESC";

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

  <!-- Watches -->
  <div class="container" id="watches">
    <h1 class="sub-heading">Best Watches</h1>
    <div class="owl-carousel owl-theme">

      <?php
      $query = "Select id,name, price, img_url from products where sub_cate_id = 5 ORDER BY id DESC";

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

  <!-- Refrigerator -->
  <div class="container" id="refrigerator">
    <h1 class="sub-heading">Best Refrigerator</h1>
    <div class="owl-carousel owl-theme">

      <?php
      $query = "Select id, name, price, img_url from products where sub_cate_id = 9 ORDER BY id DESC";

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

  <!-- Home & Kitchen -->
  <div class="container">
    <h1 class="sub-heading">Home & Kitchen</h1>

    <div class="owl-carousel owl-theme">
      <?php
      $query = "Select id, name, price, img_url from products where sub_cate_id = 11 ORDER BY id DESC";

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
<!-- PRODUCTS SECTION END  -->