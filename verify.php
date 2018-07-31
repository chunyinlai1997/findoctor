<?php
	include_once 'config.php';
	include_once 'token.php';

  $msg="";
	$flag="Verification Fail";
	if(isset($_GET['v']) && !empty($_GET['v']) AND isset($_GET['e']) && !empty($_GET['e']) AND isset($_GET['h']) && !empty($_GET['h'])){
		if($_GET['v']=="activate"){
			$email = mysql_escape_string($_GET['e']);
			$hash = mysql_escape_string($_GET['h']);
			$sql = mysql_query("SELECT id, email, verified, verify_hash FROM Users WHERE email='$email' AND verify_hash='$hash'") or die(mysql_error());
			$row = mysql_fetch_array($sql,MYSQL_NUM);
			$match  = mysql_num_rows($sql);
			$really = notVerified();
			if($row[3]==$hash){
				$msg="Verification Success! Your account has activated now!";
				$flag="Verification Success!";
				$new_hash =  md5(rand(0,1000));
				mysql_query("UPDATE Users SET verified = 1, verify_hash = '$new_hash' WHERE email = '$email'") or die(mysql_error());
			}
			else{
				if($really=="not_verified"){
					$msg="Verification Error! We have send you a new verification link to your email address. If you have any diffculties, please <a href=''>Contact Us</a> for help.";
					$v_hash = md5(rand(0,1000));
					mysql_query("UPDATE member SET hash_verification = '$v_hash' WHERE email = '$email'");
					$sql2 = mysql_query("SELECT firstname, lastname FROM Users WHERE email='$email'") or die(mysql_error());
					$row2 = mysql_fetch_array($sql2,MYSQL_NUM);
					$firstname = $row[0];
					$lastname = $row[1];
					send_email($firstname,$lastname,$email,$v_hash);
				}
				else{
					header("Location:index");
				}
			}
		}
		else{
			header("Location:index");
		}
	}
	else{
		header("Location:index");
	}

  function send_email($fname,$lname,$email,$v_hash){
  	$to      = $email; // Send email to our user
  	$subject = 'NOREPLY Account Verification| Find Doctor'; // Give the email a subject
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
?>
<html lang="en">
<head>
	<title> Verification-- Doctor Appointment System --  ABC Medical Company</title>
	<?php include 'head-info.php';?>
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
						<div class="col-12">
            <font style="color:white; font-size:1em;"><?php echo $msg; ?></font><br/>
            <a href="login"><button class="btn_1 medium">Login Now</button></a>
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
