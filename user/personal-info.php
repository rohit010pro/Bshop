<?php 
require_once("header.php"); 
require_once("../connection.php");
require_once("../function.php");
?>
    <section id="user-account">
        <div class="container">
            <div class="user-account-wrapper">
                <!-- Including Sidebar -->
                <?php require_once("sidebar.php"); 
                    if(isset($_SESSION['user-id'])){
                        $userId = $_SESSION['user-id'];
                ?>
                <main>
                    <div class="user-personal-info">
                        <h1 class="title">Personal Information</h1>
                        <?php
                            $query = "SELECT name,email,phone_no FROM users WHERE user_id = $userId";
                            $result = mysqli_query($connection,$query) or die("Query Failed");
                            $row = mysqli_fetch_assoc($result);
                        ?>
                        <div class="form-wrap">
                            <form action="#" method="POST">
                                <div class="input-field">
                                    <label>Full Name</label>
                                    <input name="full-Name" type="text" value="<?php echo $row['name']; ?>">
                                </div>
                                <div class="input-field">
                                    <label>Email</label>
                                    <input name="email" type="email" value="<?php echo $row['email']; ?>">
                                </div>
                                <div class="input-field">
                                    <label>Phone Number</label>
                                    <input name="phone-no" type="tel" value="<?php echo $row['phone_no']; ?>">
                                </div>
                                <div class="small-input-group" style="margin-top: 10px;">
                                    <label class="block" style="margin-right: 15px;">Your Gender</label>
                                    <label class="small-input-label" for="male">
                                        <input type="radio" name="gender" value="male" id="male">Male
                                    </label>
                                    <label class="small-input-label" for="female">
                                        <input type="radio" name="gender" value="female" id="female">Female
                                    </label>
                                </div>
                                <br>
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