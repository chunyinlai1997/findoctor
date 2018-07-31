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
        create();
      }
      else{
        header('Location:register?re=FAIL_CAPTCHA');
      }
    }
    else{
      header('Location:register?re=NO_SUBMIT_CAPTCHA');
    }
  }
  else{
    header('Location:register?re=NO_SUBMIT');
  }

  function create(){
  	if(isset($_POST['submit'])){
  		$firstname = clean($_POST['firstname']);
  		$lastname = clean($_POST['lastname']);
  		$password = $_POST['password1'];
  		$email = clean($_POST['email']);
      $role = "patient";
  		$join = date("Y-m-d");
  	  $hashed_password = password_hash("$password", PASSWORD_DEFAULT);
  		$v_hash = md5(rand(0,1000));

      //$profiledefaultimg = "https://i.imgur.com/mNrotks.png";
  		mysql_query("INSERT INTO Users(firstname,lastname,email,password,join_date,role,verify_hash) VALUES('$firstname','$lastname','$email','$hashed_password','$join','$role','$v_hash')")or die(mysql_error());
  		$sql = mysql_query("SELECT id FROM Users WHERE email ='$email'")or die(mysql_error());
  		$result = mysql_fetch_array($sql,MYSQL_NUM);
  		$mid =  $result[0];
  		send_email($firstname,$lastname,$email,$v_hash);
  	}
  	else{
  		header("register.php?re=NO_SUBMIT");
  	}
  }

  function clean($string) {
	   $string = str_replace('  ', ' ', $string); // Replaces all spaces with hyphens.
     $string = preg_replace('/[^A-Za-z0-9.@-_*\-]/', '', $string);
     return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}

  function send_email($fname,$lname,$email,$v_hash){
  	$to      = $email; // Send email to our user
  	$subject = ' Account Verification | Find Doctor'; // Give the email a subject
  	$message = "
  	Dear $fname $lname,

  	Thanks for signing up!
  	Your account has been created, you can activate your account by pressing the url below.

  	---------------------------------------------------------------------------------------

  	Please click this link to activate your account:
  	http://www2.comp.polyu.edu.hk/~15073415d/comp3421/findoctor/verify?v=activate&e=$email&h=$v_hash

  	Thanks,

  	Find Doctor Team
  	";

  	$headers = 'From:noreply@findoctor.team' . "\r\n";
  	mail($to, $subject, $message, $headers);
  }

  function generateRandomString($length = 5) {
      return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  }
?>
<html lang="en">
<head>
	<title>Register Successful -- Doctor Appointment System --  ABC Medical Company</title>
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
			         <font style="color:white; font-size:2em;">Thank you for the registration.
               A verification email has sent to your email adress (<?php echo $_POST['email'] ?>), you have to activate your account with the verification link.</font>
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
