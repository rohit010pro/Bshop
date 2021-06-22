<?php
session_start();

if (isset($_SESSION['otp']) == false)
  header("Location: ../error-pages/403.php");

require_once("function.php");
require_once("connection.php");

$isValidOtp = true;
if (isset($_POST['otp-verify-btn'])) {

  // For Registration Verification
  if (isset($_SESSION['register-email-verification'])) {
    $name = $_SESSION['name'];
    $mobileNo = $_SESSION['mobile-no'];
    $email = $_SESSION['email'];
    $md5Pswd = $_SESSION['md-password'];

    if ($_SESSION['otp'] == $_POST['otp']) {
      $query = "INSERT INTO users(name, phone_no, email, password)
      VALUES('$name', $mobileNo, '$email', '$md5Pswd')";

      $result = mysqli_query($connection, $query) or die("Insert Query Failed");

      $_SESSION['title'] = "Email Registered";
      $_SESSION['info'] = "Your Email - $email is registered.";

      header("Location: auth-success.php");
    } else {
      $isValidOtp = false;
    }
  }

  // To Change Password
  if (isset($_SESSION['user-email-verification']) && $_SESSION['otp'] == $_POST['otp']) {
    unset($_SESSION['otp']);
    unset($_SESSION['info']);
    header("Location: change-password.php");
  }else{
    $isValidOtp = false;
  }

}
$siteInfo = getSiteInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OTP Verification</title>
  <link rel="icon" href="<?php echo "../".$siteInfo['title_logo'];?>" type="image/gif">
  <link rel="stylesheet" href="../assets/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/common.css">
  <link rel="stylesheet" href="assets/css/formstyle.css" />
</head>

<body>

  <div id="logo">
    <a href="../">
      <img src="<?php echo "../".$siteInfo['site_logo'];?>" alt="<?php echo $siteInfo['name'];?>">
    </a>
  </div>

  <div class="form-wrapper">
    <div class="form-box">
      <h1 class="title">OTP Verification</h1>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php
        if (isset($_POST['otp-verify-btn'])) {
          if($isValidOtp == false)
            echo "<div class='alert danger'>" . "Invalid OTP" . "</div>";
        }
        ?>
        <p class="info"><?php echo $_SESSION['info']; ?></p>
        <div class="input-field">
          <input name="otp" type="text" placeholder="Enter OTP" />
          <small class="input-error"></small>
        </div>

        <input class="button" type="submit" name="otp-verify-btn" value="Verify" />
        <div id="foot">
          <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="assets/js/function.js"></script>
</body>

</html>