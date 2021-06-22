<?php
session_start();

if (isset($_SESSION['user-id']) == true)
  header('Location: ../');

require_once("function.php");
require_once("connection.php");

$isSendEmail = true;
$isPswdMatch = true;
// Check if Register Button is Clicked
if (isset($_POST['register-btn'])) {
  $name = mysqli_real_escape_string($connection, $_POST['name']);
  $mobileNo = mysqli_real_escape_string($connection, $_POST['mobile-no']);
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $md5Pswd = md5(mysqli_real_escape_string($connection, $_POST['password']));
  $confirmMd5Pswd = md5(mysqli_real_escape_string($connection, $_POST['confirm-password']));

  // If Password Match
  if ($md5Pswd == $confirmMd5Pswd && !isEmailExists($email) && !isPhoneExists($mobileNo)) {
    $_SESSION['register-email-verification'] = true;
    $_SESSION['name'] = $name;
    $_SESSION['mobile-no'] = $mobileNo;
    $_SESSION['md-password'] = $md5Pswd;
    
    $isSendEmail = sendOtp($email);
  }
  // Password doesn't Match
  else {
    $isPswdMatch =  $md5Pswd == $confirmMd5Pswd;
  }
}

$siteInfo = getSiteInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User : Sign Up</title>
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

  <div class="form-wrapper" style="margin-bottom: 100px;">
    <div class="form-box">
      <h1 class="title">Sign Up</h1>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="register-form">
        <?php
        if (isset($_POST['register-btn'])) 
        {
          if($isSendEmail == false)
            echo "<div class='alert danger'>" . "Email doesn't exists" . "</div>";
          else if ($isPswdMatch == false)
            echo "<div class='alert danger'>" . "Password doesn't matched" . "</div>";
          else if (isPhoneExists($mobileNo))
            echo "<div class='alert danger'>" . "Phone number already registered" . "</div>";
          else if (isEmailExists($email))
            echo "<div class='alert danger'>" . "Email already registered" . "</div>";
          
        }
        ?>
        <!-- <div class="alert" style="display:none;"></div> -->

        <div class="input-field">
          <input name="name" type="text" data-name="Name" placeholder="Name" value="<?php echo (isset($_POST['name']) ? $_POST['name'] : ""); ?>" />
          <small class="input-error"></small>
        </div>

        <div class="input-field">
          <input name="email" type="text" data-name="Email" placeholder="Email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ""); ?>" />
          <small class="input-error"></small>
        </div>

        <div class="input-field">
          <input name="mobile-no" type="tel" data-name="Phone Number" placeholder="Phone number" value="<?php echo (isset($_POST['mobile-no']) ? $_POST['mobile-no'] : ""); ?>" />
          <small class="input-error"></small>
        </div>

        <div class="input-field password">
          <input name="password" type="password" data-name="Password" placeholder="Password" />
          <i class="fas fa-eye eye-icon"></i>
          <small class="input-error"></small>
        </div>

        <div class="input-field password">
          <input name="confirm-password" type="password" data-name="Confirm Password" placeholder="Confirm Password" />
          <i class="fas fa-eye eye-icon"></i>
          <small class="input-error"></small>
        </div>

        <input class="button" type="submit" name="register-btn" value="Sign Up" />

        <div id="foot">
          <p>Already have an account? <a href="login.php">Sign in</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="assets/js/function.js"></script>
  <script src="assets/js/register.js"></script>
</body>

</html>