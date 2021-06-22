<?php
session_start();

require_once("function.php");
require_once("connection.php");

if (isset($_POST['send-otp'])) {
  $email = mysqli_real_escape_string($connection, $_POST['email']);

  if (isEmailExists($email)) {
    $_SESSION['user-email-verification'] = true;
    $isSendEmail = sendOtp($email);
  }
}
$siteInfo = getSiteInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password</title>
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
      <h1 class="title">Forgot Password?</h1>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php
        if (isset($_POST['send-otp']) && !isEmailExists($email)) {
          echo "<div class='alert danger'>" . "Email doesn't registered" . "</div>";
        }
        ?>
        <p class="info">We will send OTP for verification on this Email.</p>
        <div class="input-field">
          <input name="email" type="email" placeholder="Enter Email" required />
          <small class="input-error"></small>
        </div>

        <input class="button" type="submit" name="send-otp" value="Send OTP" />

        <div id="foot">
          <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="assets/js/function.js"></script>
</body>

</html>