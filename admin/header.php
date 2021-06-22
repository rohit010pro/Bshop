<?php
session_start();

if(isset($_SESSION['admin-id']) == false)
    header("Location: login.php");

ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Bharatiya Online Shopping site</title>
    <link rel="icon" href="assets/bshop-favicon.png" type="image/gif">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Side Bar Start -->
    <nav id="side-bar">
        <ul class="nav-list">
            <li class="brand">
                <a href="dashboard.php">
                    <span class="icon">
                        <img src="assets/bshop-favicon.png" alt="">
                    </span>
                    <span class="title">
                        <img src="assets/bshop-brand.png" alt="">
                    </span>
                </a>
            </li>
            <li>
                <a href="dashboard.php">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="products.php">
                    <span class="icon"><i class="fab fa-product-hunt"></i></span>
                    <span class="title">Products</span>
                </a>
            </li>
            <li>
                <a href="category.php">
                    <span class="icon"><i class="fas fa-list-ul"></i></span>
                    <span class="title">Categories</span>
                </a>
            </li>
            <li>
                <a href="sub-category.php">
                    <span class="icon"><i class="fas fa-list-ul"></i></span>
                    <span class="title">Sub-Categories</span>
                </a>
            </li>
            <li>
                <a href="orders.php">
                    <span class="icon"><i class="fas fa-shopping-bag"></i></span>
                    <span class="title">Orders</span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <span class="icon"><i class="fas fa-user"></i></span>
                    <span class="title">Users</span>
                </a>
            </li>
            <li>
                <a href="settings.php">
                    <span class="icon"><i class="fas fa-cog"></i></span>
                    <span class="title">Settings</span>
                </a>
            </li>

            <li style="position: absolute; bottom: 0; width: 100%;">
                <a href="logout.php">
                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="title">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Side Bar End -->

    <!-- Main Section Start -->
    <main id="main">
        <nav id="top-bar">
            <div class="menu-btn"></div>

            <form action="#" id="search-form" method="post">
                <div class="search-box">
                    <input class="search-input" name="search" type="search" placeholder="Search...">
                    <button class="search-btn"><i class="fa fa-search"></i></button>
                </div>
            </form>

            <!-- <div class="profile-circle drop-down-btn">
                <img src="assets/mandark2.jpg" alt="">
            </div> -->

            <div id="admin-option" class="drop-down">
                <div class="profile-circle drop-down-btn">
                    <img src="assets/image/user-logo.jfif" alt="">
                </div>

                <div class="hidden"></div>

                <div class="drop-down-menu">
                    <ul class="list">

                        <li><a href="#"><span>Hi, <?php echo $_SESSION['admin-name']; ?></span></a></li>

                        <li><a href="#">
                                <i class="fas fa-user-circle"></i>
                                <span>Your Account</span>
                            </a>
                        </li>

                        <li><a href="products.php">
                                <i class="fab fa-product-hunt"></i>
                                <span>Your Products</span>
                            </a>
                        </li>

                        <li><a href="orders.php">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Orders</span>
                            </a>
                        </li>

                        <li><a href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>