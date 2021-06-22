<nav class="user-sidebar">
    <div class="hello-user-part">
        <div class="profile-pic">
            <img src="../assets/images/user-logo.jpeg" alt="">
        </div>
        <div class="user-name">
            <h4>Hello</h4>
            <h3><?php echo  (isset($_SESSION['user-name']) ? $_SESSION['user-name'] : "") ; ?></h3>
        </div>
    </div>

    <div class="user-option-part">
        <ul class="user-option-list">
            <li class="dropdown">
                <span class="user-option dropdown-head">
                    <i class="fas fa-user"></i>
                    <span>Account Settings</span>
                </span>
                <div class="dropdown-list">
                    <a href="personal-info.php">Personal Information</a>
                    <a href="address.php">Manage Addresses</a>
                </div>
            </li>
            <li>
                <a class="user-option" href="../orders.php">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Your Orders</span>
                </a>
            </li>
            <li>
                <a class="user-option" href="../cart.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Your Cart</span>
                </a>
            </li>
            <li>
                <a class="user-option" href="../auth-user/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>