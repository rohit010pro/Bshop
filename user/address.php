<?php
require_once("header.php"); 
require_once("../connection.php");
require_once("../function.php");
?>
    <section id="user-account">
        <div class="container">
            <div class="user-account-wrapper">
                <!-- Including Header -->
                <?php require_once("sidebar.php"); 
                    if(isset($_SESSION['user-id'])){
                        $userId = $_SESSION['user-id'];
                ?>
                <main>
                    <div class="user-address">
                        <h1 class="title">Manage Address</h1>
                        <?php
                            $query = "SELECT address,pin_code,city,state,country FROM users WHERE user_id = $userId";
                            $result = mysqli_query($connection,$query) or die("Query Failed");
                            $row = mysqli_fetch_assoc($result);
                        ?>
                        <div class="form-wrap">
                            <form action="#" method="POST">
                                <div class="input-field">
                                    <label>Address</label>
                                    <textarea name="address " rows="3"><?php echo $row['address']; ?></textarea>
                                </div>
                                <div class="input-field">
                                    <label>Pin code</label>
                                    <input name="pin-code" type="number" value="<?php echo $row['pin_code']; ?>">
                                </div>
                                <div class="input-field">
                                    <label>City/District/Town</label>
                                    <input name="city" type="text" value="<?php echo $row['city']; ?>">
                                </div>
                                <div class="input-field">
                                    <label>State</label>
                                    <input name="state" type="text" value="<?php echo $row['state']; ?>">
                                </div>

                                <div class="input-field">
                                    <label>Country</label>
                                    <input name="country" type="text" value="<?php echo $row['country']; ?>">
                                </div>

                                <button class="button" type="submit">Save</button>
                            </form>
                        </div>
                    </div>
                </main>
                <?php }else{?>

                    <div class="stop-box">
                        <div class="center">
                            <h1>Not Logged In</h1>
                            <a class="btn" href="../auth-user/login.php?redirect?=<?php echo getCurrentPageUrl(); ?>">Login</a>
                            <a class="btn" href="../auth-user/register.php">Register</a>
                        </div>
                    </div>

                <?php }?>
            </div>
        </div>
    </section>

<?php require_once("footer.php"); ?>
