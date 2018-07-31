<?php
  include_once 'config.php';
  include_once 'token.php';
  if(getLoginStatus()){
  	header('Location:index');
  }

  if(isset($_POST['submit']) && !empty($_POST['submit'])){
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
      $secret = '6LcN5jQUAAAAACa2GtQVN-n7lw3gLgu6RDMCoufK';
      $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
      $responseData = json_decode($verifyResponse);
      if($responseData->success){
        generate();
      }
      else{
        header('Location:forget?re=FAIL_CAPTCHA');
      }
    }
    else{
      header('Location:forget?re=NO_SUBMIT_CAPTCHA');
    }
  }
  else{
    header('Location:forget?re=NO_SUBMIT');
  }

  function generate(){
  	if(isset($_POST['submit'])){
  		$lastname = $_POST['lastname'];
  		$email = $_POST['email'];
      $sql = mysql_query("SELECT * FROM Users WHERE lastname ='$lastname' AND email ='$email' ")or die(mysql_error());
      $match  = mysql_num_rows($sql);
      if($match>0){
        $new_pass = generateRandomString(8);
        $hashed_password = password_hash("$new_pass", PASSWORD_DEFAULT);
        mysql_query("UPDATE Users SET password = '$hashed_password' WHERE email = '$email' AND lastname='$lastname'") or die(mysql_error());
        $sql2 = mysql_query("SELECT firstname FROM Users WHERE email ='$email' ")or die(mysql_error());
        $getf = mysql_fetch_array($sql2,MYSQL_NUM);
        $firstname = $getf[0];
        send_email($firstname,$lastname,$email,$new_pass);
      }
      else{
        header('Location:forget_password.php?ac=WRONG');
      }
  	}
  	else{
  		header("forget.php?re=NO_SUBMIT");
  	}
  }

  function generateRandomString($length = 8) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  }

  function send_email($fname,$lname,$email,$new_pass){
  	$to      = $email; // Send email to our user
  	$subject = 'NOREPLY Reset Password | Find Doctor'; // Give the email a subject
  	$message = "
  	Dear $fname $lname,

    We have reeceive your reset password request!
  	Your password is reset as below:
  	-----------------------------------------------------------
  	Password: $new_pass
  	-----------------------------------------------------------
  	To protect your privacy, please change the password as soon as possible.

  	Best Regards,

  	Find Doctor Team
  	";

  	$headers = 'From:noreply@findoctor.team' . "\r\n";
  	mail($to, $subject, $message, $headers);
  }

  $email = $_POST['email'];
?>
<html lang="en">
<head>
	<title>Reset Successful -- Doctor Appointment System --  ABC Medical Company</title>
	<?php include 'head-info.php';?>
	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>
<body>
	<div id="headprint">
		<?php
				include_once 'header.php';
				gen_header();
		?>
	</div>

	<div class="layer"></div>
	<!--css-preload-->
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>
	<main>
		<div class="bg_color_2">
			<div class="container margin_60_35">
				<div>
          <div class="row justify-content-center">
						<div class="col-sm-11 col-md-8 col-6">
			         <font style="color:white; font-size:2em;">You have reset the password!
               A new temporary password has sent to your email adress (<?php echo $_POST['email'] ?>), you can login to your account again and we highly recommand you to change a new password.</font>
               <br>
               <hr>
               <a href="index"><button class="btn_1 medium">Back To Home</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
	<!-- /main -->

	<?php include 'footer.php';?>

	<div id="toTop"></div>
	<!-- Back to top button -->

	<!-- COMMON SCRIPTS -->
	<script src="./js/jquery-2.2.4.min.js"></script>
	<script src="./js/common_scripts.min.js"></script>
	<script src="./js/functions.js"></script>
	<script src="./js/header.js"></script>

</body>
</html>
