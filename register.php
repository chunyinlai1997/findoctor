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
			return "Fail Submission or Timeout! Try Again.";
		}
	}

?>
<html lang="en">
<head>
	<title>Register --Doctor Appointment System --  ABC Medical Company</title>
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
				<div id="register">
					<h1>Please register now!</h1>
					<div class="row justify-content-center">
						<div class="col-md-5">
							<?php
								$error1 = "<div class='alert alert-danger'><a class='close'data-dismiss='alert' href='#'>×</a>";
								$error2 = "</div>";
								if(isset($_GET["re"])){
									$msg = re_fail();
									echo $error1.$msg.$error2;
								}
							?>
							<form action="action_register" method="POST">
								<div class="box_form">
									<div class="form-group">
										<label>Frist Name</label>
										<input type="text" name="firstname" id="inputfirstname" class="form-control" onkeyup="safeName(this)" placeholder="Your first name" minlength="1" maxlength="255" required/>
										<div id="invalidfirstname" class="invalid-feedback" style="display:none;">
									 </div>
									</div>
									<div class="form-group">
										<label>Last name</label>
										<input type="text" name="lastname" id="inputlastname" class="form-control" onkeyup="safeName(this)" placeholder="Your last name" minlength="1" maxlength="255" required/>
										<div id="invalidlastname" class="invalid-feedback" style="display:none;">
									  </div>

									</div>
									<div class="form-group">
										<label>Email</label>
										<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Your email address" required />
										<div id="invalidemail" class="invalid-feedback" style="display:none;">
											Please provide a valid email address
									  </div>
									  <div id="invalidemail2" class="invalid-feedback" style="display:none;">
									  </div>
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="password1" class="form-control" id="password1" onkeyup="validatePass(this.value)" placeholder="Your password" minlength="6" required />
										<div id="invalidPassword1" class="invalid-feedback" style="display:none;"></div>
									</div>
									<div class="form-group">
										<label>Confirm password</label>
										<input type="password" name="password2" class="form-control" id="password2" onkeyup="checkPass(this)" placeholder="Confirm password" minlength="6" required/>
										<div id="invalidPassword2" class="invalid-feedback" style="display:none;"></div>
									</div>
									<div id="pass-info" class="clearfix"></div>
									<!--<div class="checkbox-holder text-left">
										<div class="checkbox_2">
											<input type="checkbox" value="accept_2" id="check_2" name="check_2" checked="" />
											<label for="check_2"><span></strong></span></label>
										</div>
									</div>-->
									<div class="recaptcha g-recaptcha" data-sitekey="6LcN5jQUAAAAAIHtiXMKYDvCGvfmu0OVothxYUBc"></div>
									<div class="form-group text-center add_top_30">
										<input class="btn_1 medium" type="submit" id="submit" name="submit" value="submit" disabled/>
									</div>
								</div>
								<p class="text-center link_bright"><a href="login"><strong>I have an account already</strong></a></p>
								<p class="text-center"><small>I Agree to the <strong>Terms &amp; Conditions</strong> by clicking the submit button.</small></p>
							</form>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /register -->
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

	<script>
	$(document).ready(function () {
		$("#submit" ).click(function(e) {
			if(grecaptcha.getResponse() == "") {
				e.preventDefault();
				alert("Captcha is Missing!");
			}
		});

		$('#inputfirstname').keyup(function(){
			var firstname = $(this).val();
			if(firstname.length>0){
				$('#invalidfirstname').css("color","green");
				$('#invalidfirstname').css("display", "block");
				$('#invalidfirstname').html("");
				$('#inputfirstname').removeClass( "is-invalid" ).addClass( "is-valid" );
			}
			else{
				$('#invalidfirstname').css("color","red");
				$('#invalidfirstname').css("display", "block");
				$('#invalidfirstname').html("Invalid first name!");
				$('#inputfirstname').removeClass( "is-valid" ).addClass( "is-invalid" );
			}
			finalCheck();
		});

		$('#inputlastname').keyup(function(){
			var lastname = $(this).val();
			if(lastname.length>0){
				$('#invalidlastname').css("color","green");
				$('#invalidlastname').css("display", "block");
				$('#invalidlastname').html("");
				$('#inputlastname').removeClass( "is-invalid" ).addClass( "is-valid" );
			}
			else{
				$('#invalidlastname').css("color","red");
				$('#invalidlastname').css("display", "block");
				$('#invalidlastname').html("Invalid last name!");
				$('#inputlastname').removeClass( "is-valid" ).addClass( "is-invalid" );
			}
			finalCheck();
		});

		$('#inputEmail').change(function(){
			var email = $(this).val();
			$.ajax({
				url:"check.php",
				method:"POST",
				data:{checkemail:email},
				dataType:"text",
				success:function(response){
					if(response==0&&checkEmail(email)){
						$('#invalidemail2').css("color","green");
						$('#invalidemail2').css("display", "block");
						$('#invalidemail2').html("Available email address");
						$('#inputEmail').removeClass( "is-invalid" ).addClass( "is-valid" );
					}
					else if(response==0&&!checkEmail(email)){
						$('#invalidemail2').css("color","red");
						$('#invalidemail2').css("display", "block");
						$('#invalidemail2').html("This email address is invalid");
						$('#inputEmail').removeClass( "is-valid" ).addClass( "is-invalid" );
					}
					else if(response==1&&!checkEmail(email)){
						$('#invalidemail2').css("color","red");
						$('#invalidemail2').css("display", "block");
						$('#invalidemail2').html("This email address is invalid");
						$('#inputEmail').removeClass( "is-valid" ).addClass( "is-invalid" );
					}
					else if(response==1&&checkEmail(email)){
						$('#invalidemail2').css("color","red");
						$('#invalidemail2').css("display", "block");
						$('#invalidemail2').html("This email address is already used");
						$('#inputEmail').removeClass( "is-valid" ).addClass( "is-invalid" );
					}
					finalCheck();
				}
			});
		});

		function checkEmail(email){
			var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			if(regMail.test(email)){
					return true;
				}
			else{
				return false;
			}
		}
	});

	function safeName(name){
		name.value = name.value.replace(/[^/ ,a-zA-Z-'\n\r.]+/g, '');
	}

	function validatePass(pass){
		if (pass.search(/[a-z]/) < 0) {
		  document.getElementById("password1").classList.add('is-invalid');
			document.getElementById("password1").classList.remove('is-valid');
			document.getElementById("invalidPassword1").style.display = "block";
			document.getElementById("invalidPassword1").style.color = "red";
			document.getElementById("invalidPassword1").innerHTML = "Your password must contain a lower case letter";
		}
		else if(pass.search(/[A-Z]/) < 0) {
		  document.getElementById("password1").classList.add('is-invalid');
			document.getElementById("password1").classList.remove('is-valid');
			document.getElementById("invalidPassword1").style.display = "block";
			document.getElementById("invalidPassword1").style.color = "red";
			document.getElementById("invalidPassword1").innerHTML = "Your password must contain an upper case letter";
		}
		else  if (pass.search(/[0-9]/) < 0) {
			document.getElementById("password1").classList.add('is-invalid');
			document.getElementById("password1").classList.remove('is-valid');
			document.getElementById("invalidPassword1").style.display = "block";
			document.getElementById("invalidPassword1").style.color = "red";
			document.getElementById("invalidPassword1").innerHTML = "Your password must contain a number";
		}
		else  if (pass.length < 6) {
			document.getElementById("password1").classList.add('is-invalid');
			document.getElementById("password1").classList.remove('is-valid');
			document.getElementById("invalidPassword1").style.display = "block";
			document.getElementById("invalidPassword1").style.color = "red";
			document.getElementById("invalidPassword1").innerHTML = "Your password is too short";
		}
		else{
			document.getElementById("password1").classList.remove('is-invalid');
			document.getElementById("password1").classList.add('is-valid');
			document.getElementById("invalidPassword1").style.display = "block";
			document.getElementById("invalidPassword1").innerHTML = "Valid password";
			document.getElementById("invalidPassword1").style.color = "green";
		}
		finalCheck();
	}

	function checkPass()
	{
		var pass1 = document.getElementById('password1');
	  var pass2 = document.getElementById('password2');
		if(pass1.value != pass2.value){
			document.getElementById("password2").classList.add('is-invalid');
			document.getElementById("password2").classList.remove('is-valid');
			document.getElementById("invalidPassword2").style.display = "block";
			document.getElementById("invalidPassword2").style.color = "red";
			document.getElementById("invalidPassword2").innerHTML = "Password not match";
		}
		else
		{
			document.getElementById("password2").classList.remove('is-invalid');
			document.getElementById("password2").classList.add('is-valid');
			document.getElementById("invalidPassword2").style.display = "block";
			document.getElementById("invalidPassword2").innerHTML = "Password match";
			document.getElementById("invalidPassword2").style.color = "green";
		}
		finalCheck();
	}

	function finalCheck(){
		var first = document.getElementById("inputfirstname").classList.contains('is-valid');
		var last = document.getElementById("inputlastname").classList.contains('is-valid');
		var email =  document.getElementById("inputEmail").classList.contains('is-valid');
		var pass1 =  document.getElementById("password1").classList.contains('is-valid');
		var pass2 =  document.getElementById("password2").classList.contains('is-valid');
		if( first && last && email && pass1 && pass2){
			document.getElementById("submit").disabled = false;
		}
		else{
			document.getElementById("submit").disabled = true;
		}
	}
	</script>
</body>
</html>
