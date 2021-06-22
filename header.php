<?php
if(basename($_SERVER['PHP_SELF']) == "header.php")
  header("Location: error-pages/403.php");

require("connection.php");
require("function.php");

$siteInfo = getSiteInfo();

$pageTitle = "";
$fileName = basename($_SERVER['PHP_SELF']);
switch ($fileName) {
  case 'index.php':
    $pageTitle = $siteInfo['title'];
    break;

  case 'cart.php':
    $pageTitle = "Your Cart";
    break;

  case 'orders.php':
    $pageTitle = "Your Orders";
    break;

  case 'order-details.php':
    $productId = $_REQUEST['pid'];
    $pageTitle = "Your order : " . getProductName($productId);
    break;

  case 'product-details.php':
    $productId = $_REQUEST['id'];
    $pageTitle = getProductName($productId);
    break;

  case 'product-rate.php':
    $productId = $_REQUEST['pid'];
    $pageTitle = "Rating : " . getProductName($productId);
    break;

  case 'category-products.php':
    $subCateId = $_REQUEST['sub_cate_id'];

    if ($subCateId == "" || !is_numeric($subCateId))
      header("Location: ./");

    $query = "SELECT name FROM sub_category WHERE id = $subCateId";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 0)
      header("Location: error-pages/404.php");

    $row = mysqli_fetch_assoc($result);
    $subCateName = $row['name'];
    break;

  case "search.php":
    $search = htmlspecialchars(trim($_GET['search']));
    if ($search == "")
      header("Location: ./");
    $pageTitle = "Search : " . $search;
    break;
}
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Dynamic Page title -->
  <title><?php echo $pageTitle; ?></title>
  <link rel="icon" href="<?php echo $siteInfo['title_logo'];?>" type="image/gif">

  <!-- Icon Fonts Stylesheet -->
  <link rel="stylesheet" href="assets/css/all.min.css" />
  <!-- Owl Carousel Stylesheet -->
  <link rel="stylesheet" href="assets/css/owl.carousel.css" />
  <!-- Owl Carousel Default Theme Stylesheet -->
  <link rel="stylesheet" href="assets/css/owl.theme.default.css" />
  <!-- Zoom Stylesheet -->
  <link rel="stylesheet" href="assets/css/exzoom.css">
  <!-- Common StylesSheet -->
  <link rel="stylesheet" href="assets/css/common.css">
  <!-- Header & Footer StyleSheet  -->
  <link rel="stylesheet" href="assets/css/header-footer.css" />
  <!-- Products-Section StyleSheet -->
  <link rel="stylesheet" href="assets/css/products-section.css">
  <!-- Search Stylesheet -->
  <link rel="stylesheet" href="assets/css/search.css">
  <!-- DB Products Stylesheet -->
  <link rel="stylesheet" href="assets/css/dp-products.css">
  <!-- Order Page Stylesheet -->
  <link rel="stylesheet" href="assets/css/order.css">
  <!-- Rating Stylesheet -->
  <link rel="stylesheet" href="assets/css/rating.css">
  <link rel="stylesheet" href="assets/css/product-rate.css">
</head>

<body>

  <!-- HEADER START -->
  <header id="header">
    <div id="left">
      <div id="menu-btn">
        <span class="menu-bars"></span>
      </div>
      <div id="logo">
        <a href="./">
          <img src="<?php echo $siteInfo['site_logo'];?>" alt="<?php echo $siteInfo['name'];?>">
        </a>
      </div>
    </div>

    <div id="middle">
      <div id="search-form">
        <form action="search.php" method="GET">
          <div id="search-box">
            <input id="search-input" name="search" type="search" list="search-options" autocomplete="off" placeholder="Search" />
            <button id="search-icon" type="submit">
              <i class="fas fa-search"></i>
            </button>
            <datalist id="search-options">
            </datalist>
          </div>
        </form>
      </div>
    </div>

    <div id="right">
      <div id="search-controls">
        <i id="sc-search" class="fas fa-search"></i>
        <i id="sc-close" class="fas fa-times"></i>
      </div>

      <?php
      if (isset($_SESSION['user-name']) == true) {
      ?>
        <!-- IF User Logged in -->
        <div id="user-option" class="drop-down">
          <div class="drop-down-btn">
            <span class="user-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
          </div>

          <div class="hidden"></div>

          <div class="drop-down-menu">
            <ul class="list">

              <li><a href="user/personal-info.php"><span>Hi, <?php echo $_SESSION['user-name']; ?></span></a></li>

              <li><a href="user/personal-info.php">
                  <i class="fas fa-user-circle"></i>
                  <span>Your Account</span>
                </a></li>

              <li><a href="cart.php">
                  <i class="fas fa-shopping-cart"></i>
                  <span>Your Cart</span>
                </a></li>

              <li><a href="orders.php">
                  <i class="fas fa-shopping-bag"></i>
                  <span>Your Order</span>
                </a></li>

              <li><a href="auth-user/logout.php">
                  <i class="fas fa-sign-out-alt"></i>
                  <span>Logout</span>
                </a></li>
            </ul>
          </div>
        </div>

      <?php } else {  ?>
        <!-- IF User Not Logged in -->
        <div id="user-auth">
          <a href="auth-user/login.php" id="login-btn">Login</a>
          <a href="auth-user/register.php" id="register-btn">Register</a>
        </div>
      <?php } ?>

      <div class="cart-option">
        <a href="cart.php">
          <i class="fas fa-shopping-cart"></i>
          <span id="cart-product-count">0</span>
        </a>
      </div>
    </div>
  </header>
  <!-- HEADER END -->


  <!-- SIDE BAR MENU START-->
  <nav id="side-bar">
    <div class="login-head">
      <a href="auth-user/login.php">
        <i class="fas fa-user-circle"></i>
        <?php
        if (isset($_SESSION['user-id'])) {
          echo "<span>Hello {$_SESSION['user-name']}</span>";
        } else {
          echo "<span>Sign in</span>";
        }
        ?>
      </a>
    </div>

    <div class="list-title">Category</div>
    <ul class="menu-list">
      <?php
      $query = "SELECT * FROM category";
      $result = mysqli_query($connection, $query) or die("Query Failed");
      while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <li class="dropdown">
          <div class="sub-menu-head"><?php echo $row['name']; ?></div>
          <ul class="sub-menu-list">
            <div class="back-menu">
              <span class="icon"><i class="fa fa-arrow-left"></i></span>
              <span class="title">Main Menu</span>
            </div>
            <div class="list-title"><?php echo $row['name']; ?></div>
            <?php
            $cateID = $row['id'];
            $subQuery = "SELECT * FROM sub_category WHERE cate_id = $cateID";

            $subQueryResult = mysqli_query($connection, $subQuery) or die("Sub Query Failed");
            while ($subRow = mysqli_fetch_assoc($subQueryResult)) {
            ?>
              <li>
                <a href="category-products.php?sub_cate_id=<?php echo $subRow['id']; ?>"><?php echo $subRow['name']; ?></a>
              </li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>
    </ul>


    <div class="list-title">Help</div>
    <ul class="menu-list">
      <?php if (isset($_SESSION['user-id'])) { ?>
        <li>
          <a href="user/personal-info.php">Your Account</a>
        </li>
        <li>
          <a href="cart.php">Your Cart</a>
        </li>
        <li>
          <a href="orders.php">Your Orders</a>
        </li>
        <li>
          <a href="auth-user/logout.php">Sign out</a>
        </li>
      <?php } else { ?>
        <li>
          <a href="auth-user/login.php">Sign in</a>
        </li>
        <li>
          <a href="auth-user/register.php">Sign Up</a>
        </li>
      <?php } ?>
    </ul>
  </nav>
  <!-- SIDE BAR MENU END -->


  <!-- OVERLAY START -->
  <div id="overlay"></div>
  <!-- OVERLAY START-->

  <button id="scrollToTopBtn" type="button">
    <i class="fa fa-arrow-up"></i>
  </button>