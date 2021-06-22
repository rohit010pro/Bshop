<?php
require_once("header.php");
require_once("connection.php");

$adminId = $_SESSION['admin-id'];
?>
<section>
    <div class="box-wrapper">
        <div class="box">
            <a href="products.php">
                <div class="box-content">
                    <div class="first">
                        <h1 class="number">
                            <?php
                            $query = "SELECT count(id) as total_product FROM products WHERE seller_id = $adminId";
                            $result = mysqli_query($connection, $query) or die("Query Failed");
                            $row = mysqli_fetch_assoc($result);
                            echo (mysqli_num_rows($result) > 0 ? $row['total_product'] : 0);
                            ?>
                        </h1>
                        <p class="type">Products</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="box">
            <a href="orders.php">
                <div class="box-content">
                    <div class="first">
                        <h1 class="number">
                            <?php
                            $query = "SELECT count(order_ref) as total_orders FROM order_detail od JOIN products p
                                    ON od.product_id = p.id 
                                    WHERE od.status = 'pending' AND p.seller_id = $adminId";
                            $result = mysqli_query($connection, $query) or die("Query Failed");
                            $row = mysqli_fetch_assoc($result);
                            echo (mysqli_num_rows($result) > 0 ? $row['total_orders'] : 0);
                            ?>
                        </h1>
                        <p class="type">Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="box">
            <div class="box-content">
                <div class="first">
                    <h1 class="number">
                        <?php
                        $query = "SELECT count(f.id) as total_review FROM feedback f JOIN products p
                                ON f.product_id = p.id WHERE p.seller_id = $adminId";

                        $result = mysqli_query($connection, $query) or die("Query Failed");
                        $row = mysqli_fetch_assoc($result);
                        echo (mysqli_num_rows($result) > 0 ? $row['total_review'] : 0);
                        ?>
                    </h1>
                    <p class="type">Reviews</p>
                </div>
                <div class="icon">
                    <i class="fa fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="box">
            <a href="users.php">
                <div class="box-content">
                    <div class="first">
                        <h1 class="number">
                            <?php
                            $query = "SELECT count(user_id) as total_user FROM users";
                            $result = mysqli_query($connection, $query) or die("Query Failed");
                            $row = mysqli_fetch_assoc($result);
                            echo (mysqli_num_rows($result) > 0 ? $row['total_user'] : 0);
                            ?>
                        </h1>
                        <p class="type">Users</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<section>
    <div class="order-user-wrapper" style="min-height: 70vh;">
        <div class="orders">
            <div class="box-header">
                <h1>Recent Order</h1>
                <a href="orders.php" class="view-btn">View all</a>
            </div>
            <?php
            $query = "SELECT od.order_ref, p.name, (od.sell_price * od.order_quantity) as total_price, od.payment_status, od.status 
            FROM order_detail od JOIN products p ON od.product_id = p.id WHERE p.seller_id = $adminId";

            $result = mysqli_query($connection, $query) or die("Query Failed");
            if (mysqli_num_rows($result) > 0) {
            ?>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ref</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo "#" . $row['order_ref']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['total_price']; ?></td>
                                <td><?php echo $row['payment_status']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else {
                echo "<h1 style='text-align:center;'>No Order Found.</h1>";
            } ?>
        </div>

        <div class="users">
            <div class="box-header">
                <h1>Recent Users</h1>
                <a href="users.php" class="view-btn">View all</a>
            </div>
            <?php
            $query = "SELECT user_id,name FROM users ORDER BY user_id DESC LIMIT 7";
            $result = mysqli_query($connection, $query) or die("Query Failed");
            if (mysqli_num_rows($result) > 0) {
            ?>
                <ul class="user-list">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <li>
                            <div class="profile">
                                <img src="assets/image/user-logo.jfif" alt="profile-Image">
                            </div>
                            <span><?php echo $row['name']; ?></span>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else {
                echo "<h1 style='text-align:center;'>No User Found.</h1>";
            } ?>
        </div>
    </div>
</section>

<?php
require_once("footer.php");
?>