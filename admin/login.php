<?php
session_start();

if (isset($_SESSION['admin-id']) == true)
  header("Location: ./");

require('connection.php');
require("function.php");

if (isset($_POST['login-btn'])) {
  $emailOrPhone = mysqli_real_escape_string($connection, trim($_POST['email-or-phone']));
  $password = md5(trim($_POST['password']));

  $emailOrPhoneSql;
  if (is_numeric($emailOrPhone)) { // Phone
    $emailOrPhoneSql = " phone_no = $emailOrPhone ";
  } else { // Email
    $emailOrPhoneSql = " email='$emailOrPhone' ";
  }

  $query = "Select admin_id, name From admin 
            Where $emailOrPhoneSql AND password='$password'";

  $result = mysqli_query($connection, $query) or die("Fetch Query Failed");

  $isValidUser = false;
  if (mysqli_num_rows($result) === 1) {
    $isValidUser = true;
    $row = mysqli_fetch_assoc($result);
    session_start();
    $_SESSION['admin-id'] = $row['admin_id'];
    $_SESSION['admin-name'] = $row['name'];

    // When Request Come from Product Detail Page 
    if (isset($_GET['redirect_url'])) {
      header("Location: " . $_GET['redirect_url']);
    }
    header("Location: ./");
  } else {
    $isValidUser = false;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin : Sign in</title>
  <link rel="icon" href="assets/bshop-favicon.png" type="image/gif">
  <link rel="stylesheet" href="assets/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/formstyle.css" />
</head>

<body>
  <div id="logo">
    <a href="./">
      <img src="assets/bshop-brand.png" alt="bshop-brand">
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
          <!-- <a href="forgot-pswd.php" class="forgot-pswd">Forgot Password?</a> -->
        </div>
        <input class="button" type="submit" name="login-btn" value="Login" />
        <br>
        <br>
      </form>
    </div>
  </div>

  <script src="assets/js/function.js"></script>
  <script src="assets/js/login.js"></script>
</body>

</html>