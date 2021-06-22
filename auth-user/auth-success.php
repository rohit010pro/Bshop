<?php
require_once("function.php");

session_start();

$siteInfo = getSiteInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Success</title>
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
      <h1 class="title"><?php echo $_SESSION['title']; ?></h1>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <p class="info"><?php echo $_SESSION['info']; ?></p>
        <a class="button" href="login.php">Login Now</a>
      </form>

    </div>
  </div>

<?php session_unset(); ?>
</body>

</html>