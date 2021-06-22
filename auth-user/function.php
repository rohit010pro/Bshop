<!-- Auth Function-->
<?php
require_once("connection.php");
require_once("../function.php");

function isEmailExists($email)
{
	global $connection;

	$query = "Select user_id from users Where email = '$email'";

	$result = mysqli_query($connection, $query);

	if (mysqli_num_rows($result) == 1)
		return true;
	return false;
}

function isPhoneExists($phoneNo)
{
	global $connection;

	$query = "Select user_id from users Where phone_no = $phoneNo";

	$result = mysqli_query($connection, $query);

	if (mysqli_num_rows($result) == 1)
		return true;
	return false;
}


function sendOtp($email)
{
    // Include library file
  require_once 'VerifyEmail.class.php'; 

  // Initialize library class
  $mail = new VerifyEmail();

  // Set the timeout value on stream
  $mail->setStreamTimeoutWait(20);

  // Set debug output mode
  $mail->Debug= TRUE; 
  $mail->Debugoutput= 'html'; 

  // Set email address for SMTP request
  $mail->setEmailFrom('businesswithbshop@gmail.com');

  // Check if email is valid and exist
  if($mail->check($email)){ 
      $otp = rand(111111, 999999);
      $subject = "Email Verification Code";
      $message = "Your Email verification OTP(one time password) is  $otp";
      $sender = "From: businesswithbshop@gmail.com";

      if(mail($email, $subject, $message, $sender)){
          $info = "We've sent a verification code to your email - $email";
          $_SESSION['otp'] = $otp;
          $_SESSION['info'] = $info;
          $_SESSION['email'] = $email;
          header('Location: otp-verify.php');
      }else{
          die("Error Occured while sending OTP!");
      }

  }elseif(verifyEmail::validate($email)){ 
     return false; 
  }
}

// For User Login
function loginInUser($email, $md5Pswd)
{
  global $connection;

  $query = "SELECT user_id, name, email FROM users 
  WHERE email='$email' AND password='$md5Pswd'";

  $result = mysqli_query($connection, $query) or die("Fetch Query Failed");

  if(mysqli_num_rows($result) == 1){
    $row = mysqli_fetch_assoc($result);
  	session_unset();
    $_SESSION['user-id'] = $row['user_id'];
    $_SESSION['user-name'] = $row['name'];
    header("Location: ../");
  }else{
	  die("No or more than one Record found..");
  }
}

?>