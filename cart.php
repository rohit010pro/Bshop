<?php require_once("header.php"); ?>

<section id="cart-section">
    <div class="container">
        <?php
        if (isset($_SESSION['user-id'])) { ?>
        
            <h1 class="sub-heading">Your Cart</h1>
            
            <div id="db-products">
            </div>

            <a href="./" class="btn" style="margin-top: 40px;">Continue Shopping</a>
        
        <?php } else { ?>
            <div class="stop-box">
                <div class="center">
                    <h1>Not Logged In</h1>
                    <a class="btn" href="auth-user/login.php?redirect_url=<?php echo urlencode(getCurrentPageUrl()); ?>">Login</a>
                    <a class="btn" href="auth-user/register.php">Register</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Toast -->
    <div class="toast">
        <span class="icon"><i class="fa fa-exclamation-triangle"></i></span>
        <span class="msg">Toast</span>
        <span class="close">&times;</span>
    </div>

    <!-- Rating Popup Box -->
    <div class="popup-box">
        <div class="popup-close">&times;</div>
        <div class="confirm-box">
            <div class="icon">
                <i class="fa fa-exclamation-triangle fa-2x"></i>
            </div>
            <div class="msg">
                Are you sure you want to remove this product from your cart ?
            </div>
            <div class="buttons">
                <button class="btn" id="no">No</button>
                <button class="btn" id="yes">Yes</button>
            </div>
        </div>
    </div>
    <!-- / Rating Popup Box -->
    <div class="overlay"></div>
</section>

<!-- Including Footer Section -->
<?php require("footer.php"); ?>