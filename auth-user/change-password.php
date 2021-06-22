<?php
session_start();

require_once("function.php");
require_once("connection.php");

$isPswdMatch = false;
if (isset($_POST['change-pswd-btn'])) {
  $pswd = md5(mysqli_real_escape_string($connection, $_POST['password']));
  $confirmPswd = md5(mysqli_real_escape_string($connection, $_POST['confirm-password']));

  if ($pswd == $confirmPswd) {
    $isPswdMatch = true;
    $email = $_SESSION['email'];
    $query = "UPDATE users SET password = '$pswd' WHERE email = '$email'";
    $result = mysqli_query($connection, $query) or die("Update Query Failed");

    $_SESSION['title'] = "Password changed";
    $_SESSION['info'] = "Your Password of Account - $email is changed.<br>Now, you can login with your new password.";
    header("Location: auth-success.php");
  }
}

$siteInfo = getSiteInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Password</title>
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
      <h1 class="title">Change Password</h1>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php
        if (isset($_POST['change-pswd-btn']) && !$isPswdMatch) {
          echo "<div class='alert danger'>" . "Password doesn't Match" . "</div>";
        }
        ?>
        <div class="input-field password">
          <input name="password" type="password" placeholder="Create New Password" value="<?php echo (isset($_POST['password']) ? $_POST['password'] : ""); ?>" />
          <i class="fas fa-eye eye-icon"></i>
          <small class="input-error"></small>
        </div>

        <div class="input-field password">
          <input name="confirm-password" type="password" placeholder="Confirm your Password" value="<?php echo (isset($_POST['confirm-password']) ? $_POST['confirm-password'] : ""); ?>" />
          <i class="fas fa-eye eye-icon"></i>
          <small class="input-error"></small>
        </div>

        <input class="button" type="submit" name="change-pswd-btn" value="Change Password" />
        <div id="foot">
          <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
      </form>
    </div>
  </div>

  <style>

  </style>

  <script src="assets/js/function.js"></script>
</body>

</html>