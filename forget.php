<?php
	include 'config.php';
	include_once 'token.php';
	$isLoggedin = getLoginStatus();
	if($isLoggedin){
		header("Location:index");
	}

	function re_fail(){
		if($_GET["re"]=="FAIL_CAPTCHA"){
			return "Fail Captcha Verification! Try Again.";
		}
		else if($_GET["re"]=="NO_SUBMIT_CAPTCHA"){
			return "No Captcha Submission! Try Again.";
		}
		else if($_GET["re"]=="NO_SUBMIT"){
			return "Fail Login Submission or Timeout! Try Again.";
		}
	}

	function ac_fail(){
		if($_GET["ac"]=="WRONG"){
			return "Wrong email or lastname! Try Again!";
		}
		else if($_GET["ac"]=="NO_SUBMIT"){
			return "Empty Submission! Try Again.";
		}
	}

?>
<html lang="en">
<head>
	<title>Forget Password --Doctor Appointment System --  ABC Medical Company</title>
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
				<div id="login">
					<h1>Please login to Findoctor!</h1>
					<div class="row justify-content-center">
						<div class="col-md-12">
						<?php
							$error1 = "<div class='alert alert-danger'><a class='close'data-dismiss='alert' href='#'>×</a>";
							$error2 = "</div>";
							if(isset($_GET["re"])){
								$msg = re_fail();
								echo $error1.$msg.$error2;
							}
							else if(isset($_GET["ac"])){
								$msg = ac_fail();
								echo $error1.$msg.$error2;
							}
						?>
						</div>
					</div>
					<div class="box_form">
						<form method="POST" action="action_forget.php">
							<div class="form-group">
								<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Your email address" onkeyup="checkEmail(this.value)" required />
								<div id="invalidemail2" class="invalid-feedback" style="display:none;"></div>
							</div>
							<div class="form-group">
								<input type="lastname" name="lastname" id="lastname" class="form-control" placeholder="Your lastname" minlength="2" onkeyup="checkPass(this.value)" required />
								<div id="invalidlastname" class="invalid-feedback" style="display:none;"></div>
							</div>
							<div class="recaptcha g-recaptcha" data-sitekey="6LcN5jQUAAAAAIHtiXMKYDvCGvfmu0OVothxYUBc"></div>
							<div class="form-group text-center add_top_20">
								<input class="btn_1 medium" type="submit" id="submit" name="submit" value="SUBMIT" disabled />
							</div>
						</form>
					</div>
				</div>
				<!-- /login -->
			</div>
		</div>
	</main>
	<!-- /main -->

	<?php include 'footer.php';?>

	<div id="toTop"></div>
	<!-- Back to top button -->

	<!-- COMMON SCRIPTS -->
	<!-- COMMON SCRIPTS
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	-->
	<script src="./js/jquery-2.2.4.min.js"></script>
	<script src="./js/common_scripts.min.js"></script>
	<script src="./js/functions.js"></script>
	<script src="./js/header.js"></script>

	<script>
	$(document).ready(function () {
		$("#submit" ).click(function(e) {
			if(grecaptcha.getResponse() == "") {
				e.preventDefault();
				alert("Captcha is Missing!");
			}
		});
	});

	function checkEmail(email){
		var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
		if(regMail.test(email)){
			$('#invalidemail2').css("color","green");
			$('#invalidemail2').css("display", "block");
			$('#invalidemail2').html("");
			$('#inputEmail').removeClass( "is-invalid" ).addClass( "is-valid" );
		}
		else{
			$('#invalidemail2').css("color","red");
			$('#invalidemail2').css("display", "block");
			$('#invalidemail2').html("Wrong email format");
			$('#inputEmail').removeClass( "is-valid" ).addClass( "is-invalid" );
		}
		finalCheck();
	}

	function checkPass(pass){
		if(pass.length>0){
			$('#invalidlastname').css("color","green");
			$('#invalidlastname').css("display", "block");
			$('#invalidlastname').html("");
			$('#lastname').removeClass( "is-invalid" ).addClass( "is-valid" );
		}
		else{
			$('#invalidlastname').css("color","red");
			$('#invalidlastname').css("display", "block");
			$('#invalidlastname').html("Invalid last name!");
			$('#lastname').removeClass( "is-valid" ).addClass( "is-invalid" );
		}
		finalCheck();
	}

	function finalCheck(){
		var email =  document.getElementById("inputEmail").classList.contains('is-valid');
		var lastname =  document.getElementById("lastname").classList.contains('is-valid');
		if(lastname && email){
			document.getElementById("submit").disabled = false;
		}
		else{
			document.getElementById("submit").disabled = true;
		}
	}

	</script>

</body>
</html>
