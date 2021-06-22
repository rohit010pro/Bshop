<?php
session_start();

if (isset($_SESSION['user-id']) == true)
  header('Location:  ../');

require_once("function.php");
require_once("connection.php");

if(isset($_GET['redirect_url']))
  $_SESSION['redirect-url'] = urldecode($_GET['redirect_url']);

if (isset($_POST['login-btn'])) {
  $emailOrPhone = mysqli_real_escape_string($connection, $_POST['email-or-phone']);
  $password = md5(mysqli_real_escape_string($connection, $_POST['password']));

  $emailOrPhoneSql;
  if (is_numeric($emailOrPhone)) { // Phone
    $emailOrPhoneSql = " phone_no = $emailOrPhone ";
  } else { // Email
    $emailOrPhoneSql = " email='$emailOrPhone' ";
  }

  $query = "Select user_id, name From users 
            Where $emailOrPhoneSql AND password='$password'";

  $result = mysqli_query($connection, $query) or die("Fetch Query Failed");

  $isValidUser = false;
  if (mysqli_num_rows($result) === 1) {
    $isValidUser = true;
    $row = mysqli_fetch_assoc($result);
    
    $_SESSION['user-id'] = $row['user_id'];
    $_SESSION['user-name'] = $row['name'];

    if(isset($_SESSION['redirect-url'])){
      $redirectUrl = $_SESSION['redirect-url'];
      unset($_SESSION['redirect-url']);
      header("Location: $redirectUrl");
    }else{
      header("Location: ../");
    }
    
  }
}
$siteInfo = getSiteInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign in | Bshop Account</title>
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
      <h1 class="title">Sign In</h1>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login-form">
        <?php
        if (isset($_POST['login-btn'])) {
          echo '<div class="alert danger">';
          if (is_numeric($emailOrPhone) && !isPhoneExists($emailOrPhone))
            echo "Phone number doesn't register";
          else if (!is_numeric($emailOrPhone) && !isEmailExists($emailOrPhone))
            echo "Email doesn't register";
          else
            echo "Invalid Password";
          echo "</div>";
        }
        ?>
        <div class="input-field">
          <input name="email-or-phone" type="text" data-name="Email or Phone" placeholder="Email or Phone" value="<?php echo (isset($_POST['login-btn'])) ? $_POST['email-or-phone'] : ''; ?>" />
          <small class="input-error"></small>
        </div>
        <div class="input-field password">
          <input name="password" type="password" data-name="Password" placeholder="Password" />
          <i class="fas fa-eye eye-icon"></i>
          <small class="input-error"></small>
          <a href="forgot-pswd.php" class="forgot-pswd">Forgot Password?</a>
        </div>
        <input class="button" type="submit" name="login-btn" value="Login" />

        <!-- Login with google button -->
        <a href="<?php echo $google_client->createAuthUrl(); ?>" class="button google-login-btn" type="button">
          <i class="fab fa-google"></i>
          <span>Sign in with Google</span>
        </a>

        <div id="foot">
          <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="assets/js/function.js"></script>
  <script src="assets/js/login.js"></script>
</body>

</html>