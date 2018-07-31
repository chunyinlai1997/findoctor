<?php
  include_once 'config.php';
  include_once 'token.php';
  if(!getLoginStatus()){
  	header('Location:login');
  }
  $v = notVerified();
  if(!$v){
    header('Location:index');
  }
  $title = "";
  $word = "";
  $alt = "";
  $alert_color = "alert-danger";
  $complete = 0;
  if(isset($_POST['submit1'])){
    $id = isloggedin();
    $email = $_POST['email'];
  	$sql2 = mysql_query("SELECT firstname, lastname,verify_hash FROM Users WHERE id!='$id'")or die(mysql_error());
  	$result = mysql_fetch_array($sql2,MYSQL_NUM);
  	$fname = $result[0];
  	$lname = $result[1];
  	$v_hash = $result[2];
  	send_email($fname,$lname,$email,$v_hash);
  	mysql_query("UPDATE Users SET email='$email' WHERE id='$id'");
    $alt = "<div class='alert alert-success' role='alert'><strong>Well done!</strong> You have successfully requested a new activation email, please activate your account now.<button type='button' class='close' data-dismiss='alert' aria-label='Close'></div>";
  }

  if(isset($_POST['submit2'])){
    $id = isloggedin();
    $hkid = $_POST['hkid'];
    $phone =  $_POST['phone'];
    $gender =  $_POST['gender'];
    $address =  $_POST['address'];
    $district =  $_POST['district'];
    $dob = $_POST['dob'];
    $v = notVerified();
    if($v=='inactive'){
      $sql2 = mysql_query("SELECT * FROM Patient WHERE user_id='$id'")or die(mysql_error());
      $num_rows = mysql_num_rows($sql2);
      if($num_rows==0){
        mysql_query("INSERT INTO  Patient(user_id, date_of_birth,address,district,hkid,gender) VALUES ('$id', '$dob', '$address', '$district', '$hkid', '$gender')");
        mysql_query("UPDATE Users SET phone='$phone', status='active' WHERE id='$id'");
        $alert_color = "alert-success";
        $alt = "<div class='alert alert-success' role='alert'><strong>Well done!</strong> You have successfully completed your personal profile, You are now an active user.<button type='button' class='close' data-dismiss='alert' aria-label='Close'></div>";
        $complete = 1;
      }
      else{
        header("Location:index");
      }
    }
    else{
      header("Location:index");
    }
  }

  if($complete==0){
    if($v=="not_verified"){
      $email = getEmail();
      $title = "Account Not Verified";
      $word = "You have not verify your account yet. Please check your email(".$email.") and click on the activation link.";
    }
    else if($v=="inactive"){
      $firstname = getFirstName();
      $title = "Account Inactive";
      $word = "Welcome, $firstname. Before you enjoy our service, please complete your personal profile for facilating the appointment service.";
    }
    else if($v=="blocked"){
      $title = "Account Blocked";
      $word =  "Your account was blocked due to security problems or abuse of service. Please <a href='#'>contact us</a> to solve your account issue.";
    }
  }

  function send_email($fname,$lname,$email,$v_hash){
  	$to      = $email; // Send email to our user
  	$subject = 'NOREPLY Resend Account Verification | Find Doctor'; // Give the email a subject
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
	<title>Account Issue -- Doctor Appointment System --  ABC Medical Company</title>
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
						<div class="col-12">
               <?php echo $alt;?>
               <h1 class="<?php echo $alert_color; ?>" style="align:center;"><?php echo $title;?></h1>
			         <font style="color:white; font-size:2em;"><?php echo $word; ?></font>
               <br>
               <hr>
               <?php
               if($v=="inactive" && $complete==0){
                 echo "
                 <main>
                   <div id='hero_register'>
                     <div class='container margin_120_95'>
                       <div class='row'>
                         <div class='col-lg-6'>
                           <h1>Just few more steps to go</h1>
                           <p class='lead'>Te pri adhuc simul. No eros errem mea. Diam mandamus has ad. Invenire senserit ad has, has ei quis iudico, ad mei nonumes periculis.</p>
                           <div class='box_feat_2'>
                             <i class='pe-7s-map-2'></i>
                             <h3>Let patients to Find you!</h3>
                             <p>Ut nam graece accumsan cotidieque. Has voluptua vivendum accusamus cu. Ut per assueverit temporibus dissentiet.</p>
                           </div>
                           <div class='box_feat_2'>
                             <i class='pe-7s-date'></i>
                             <h3>Easly manage Bookings</h3>
                             <p>Has voluptua vivendum accusamus cu. Ut per assueverit temporibus dissentiet. Eum no atqui putant democritum, velit nusquam sententiae vis no.</p>
                           </div>
                           <div class='box_feat_2'>
                             <i class='pe-7s-phone'></i>
                             <h3>Instantly via Mobile</h3>
                             <p>Eos eu epicuri eleifend suavitate, te primis placerat suavitate his. Nam ut dico intellegat reprehendunt, everti audiam diceret in pri, id has clita consequat suscipiantur.</p>
                           </div>
                         </div>
                         <!-- /col -->
                         <div class='col-lg-6 ml-auto'>
                           <div class='box_form'>
                             <form action='account_issue' method='POST'>
                               <div class='row'>
                                 <div class='col-md-6 '>
                                   <div class='form-group'>
                                     <label for='hkid' class='col-12 col-form-label'>HKID</label>
                                     <input type='text' id='hkid' onkeyup='validateHKID()' minlength='8' maxlength='10' name='hkid' class='form-control' placeholder='e.g. A1234567' required/>
                                     <div id='invalidhkid' class='invalid-feedback' style='display:none;'></div>
                                   </div>
                                 </div>
                                 <div class='col-md-6'>
                                   <div class='form-group row'>
                                   <label for='hkid' class='col-12 col-form-label'>Date of Birth</label>
                                   <input class='form-control' onchange='validateDOB()' type='date' name='dob' id='dob' value='2018-05-12' required />
                                   <div id='invaliddob' class='invalid-feedback' style='display:none;'></div>
                                   </div>
                                   </div>
                               </div>
                               <!-- /row -->
                               <div class='row'>
                                 <div class='col-lg-12'>
                                   <div class='form-group'>
                                     <label for='address' class='col-12 col-form-label'>Address</label>
                                     <input type='text' minlength='5' onkeyup='validateAddress()' name='address' id='address' class='form-control' placeholder='Your Address' required/>
                                     <div id='invalidaddress' class='invalid-feedback' style='display:none;'></div>
                                   </div>
                                 </div>
                               </div>
                               <!-- /row -->
                               <div class='row'>
                                 <div class='col-lg-12'>
                                   <div class='form-group'>
                                     <label for='district' class='col-12 col-form-label'>District</label>
                                     <select class='form-control' onchange='valiateDistrict()' name='district' id='district' required>
                                     <option selected disabled hidden>District</option>
                                     <option disabled='true'>--Hong Kong Island--</option>
                                     <option disabled='true'></option>
                                     <option value='Central & Western District'>Central & Western District 中西區 </option>
                                     <option value='Eastern District'>Eastern District 東區 </option>
                                     <option value='Southern District'>Southern District 南區 </option>
                                     <option value='Wan Chai District'>Wan Chai District 灣仔 </option>
                                     <option disabled='true'></option>
                                     <option disabled='true'>--Kowloon--</option>
                                     <option disabled='true'></option>
                                     <option value='Kowloon City District'>Kowloon City District 九龍城 </option>
                                     <option value='Kwun Tong District'>Kwun Tong District 觀塘 </option>
                                     <option value='Sham Shui Po District'>Sham Shui Po District 深水埗  </option>
                                     <option value='Wong Tai Sin District'> Wong Tai Sin District 黃大仙 </option>
                                     <option value='Yau Tsim Mong District'>Yau Tsim Mong District 油尖旺  </option>
                                     <option disabled='true'></option>
                                     <option disabled='true'>--New Territories--</option>
                                     <option disabled='true'></option>
                                     <option value='Islands District'> Islands District 離島 </option>
                                     <option value='Kwai Tsing District'> Kwai Tsing District 葵青 </option>
                                     <option value='North District '>North District 北區  </option>
                                     <option value='Sai Kung District'>Sai Kung District 西貢 </option>
                                     <option value='Sha Tin District'>Sha Tin District 沙田 </option>
                                     <option value='Tai Po District'>Tai Po District 大埔 </option>
                                     <option value='Tsuen Wan District'>Tsuen Wan District 荃灣 </option>
                                     <option value='Tuen Mun District'>Tuen Mun District 屯門 </option>
                                     <option value='Yuen Long District'>Yuen Long District元朗</option>
                                     </select>
                                     <div id='invaliddistrict' class='invalid-feedback' style='display:none;'></div>
                                   </div>
                                 </div>
                               </div>
                               <!-- /row -->
                               <div class='row'>
                                 <div class='col-md-6'>
                                   <div class='form-group'>
                                     <label for='phonenum' class='col-12 col-form-label'>Phone Number</label>
                                     <input type='text' name='phone' id='phonenum' onkeyup='validatePhone(this)' minlength='8' maxlength='8' class='form-control' placeholder='Your mobile phone' required/>
                                     <div id='invalidphone' class='invalid-feedback' style='display:none;'></div>
                                   </div>
                                 </div>
                                 <div class='col-md-6'>
                                   <div class='form-group'>
                                     <label for='gender' class='col-12 col-form-label'>Gender</label>
                                     <select class='form-control' onchange='valiateGender()' name='gender' id='gender' required>
                                       <option value='' selected />Gender
                                       <option value='M'>M
                                       <option value='F'>F
                                       <option value='Other'>Other
                                     </select>
                                     <div id='invalidgender' class='invalid-feedback' style='display:none;'></div>
                                   </div>
                                 </div>
                               </div>
                               <!-- /row -->
                               <p class='text-center add_top_30'><input type='submit' class='btn_1' value='submit' name='submit2' id='submit2' disabled /></p>
                               <div class='text-center'><small>Ut nam graece accumsan cotidieque. Has voluptua vivendum accusamus cu. Ut per assueverit temporibus dissentiet.</small></div>
                             </form>
                           </div>
                           <!-- /box_form -->
                         </div>
                         <!-- /col -->
                       </div>
                       <!-- /row -->
                     </div>
                     <!-- /container -->
                   </div>
                   <!-- /hero_register -->
                 </main>
                 <!-- /main -->
                 ";
               }
               else if($v=="not_verified" && $complete==0){
                 echo "
                 <div class='col-lg-12'>
                   <div class='card'>
                     <div class='card-header'>Reset Account Email</div>
                     <div class='card-body card-block' id='not_verified_form' >
                       <form action='account_issue' method='post'>
                         <div class='form-group'>
                           <div class='input-group'>
                             <input type='email' id='email' name='email' placeholder='Input a valid email address' class='form-control'>
                           </div>
                           <div id='invalidemail2' class='invalid-feedback' style='display:none;'>
       									  </div>
                         </div>
                         <div class='form-actions form-group'>
                           <button type='submit' id='submit1' name='submit1' value='submit1' class='btn btn-primary btn-sm' disabled>Submit</button>
                          </div>
                       </form>
                     </div>
                   </div>
                 </div>
                 ";
               }

               if($complete==1){
                 echo "
                 <br>
                 <hr>
                 <a href='index'><button class='btn_1 medium'>Back To Home</button></a>
                 ";
               }

               ?>
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
  <script>
  $(document).ready(function () {
    $('#email').change(function(){
      var email = $(this).val();
      $.ajax({
        url:"check.php",
        method:"POST",
        data:{simplecheckemail:email},
        dataType:"text",
        success:function(response){
          if(response==0&&checkEmail(email)){
            $('#invalidemail2').css("color","green");
            $('#invalidemail2').css("display", "block");
            $('#invalidemail2').html("Valid email address");
            $('#email').removeClass( "is-invalid" ).addClass( "is-valid" );
          }
          else if(response==0&&!checkEmail(email)){
            $('#invalidemail2').css("color","red");
            $('#invalidemail2').css("display", "block");
            $('#invalidemail2').html("This email address is invalid");
            $('#email').removeClass( "is-valid" ).addClass( "is-invalid" );
          }
          else if(response==1&&!checkEmail(email)){
            $('#invalidemail2').css("color","red");
            $('#invalidemail2').css("display", "block");
            $('#invalidemail2').html("This email address is invalid");
            $('#email').removeClass( "is-valid" ).addClass( "is-invalid" );
          }
          else if(response==1&&checkEmail(email)){
            $('#invalidemail2').css("color","red");
            $('#invalidemail2').css("display", "block");
            $('#invalidemail2').html("This email address is already used by other user");
            $('#email').removeClass( "is-valid" ).addClass( "is-invalid" );
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

  function finalCheck(){
    var email =  document.getElementById("email").classList.contains('is-valid');
    if(email){
      document.getElementById("submit1").disabled = false;
    }
    else{
      document.getElementById("submit1").disabled = true;
    }
  }

  function validateHKID(){
    var hkid = String(document.getElementById("hkid").value);
    if(!IsHKID(hkid)){
      document.getElementById("hkid").classList.add('is-invalid');
			document.getElementById("hkid").classList.remove('is-valid');
			document.getElementById("invalidhkid").style.display = "block";
			document.getElementById("invalidhkid").style.color = "red";
			document.getElementById("invalidhkid").innerHTML = "Invalid HKID";
    }
    else{
      document.getElementById("hkid").classList.remove('is-invalid');
      document.getElementById("hkid").classList.add('is-valid');
      document.getElementById("invalidhkid").style.display = "block";
      document.getElementById("invalidhkid").innerHTML = "Valid HKID";
      document.getElementById("invalidhkid").style.color = "green";
    }
    finalCheck2();
  }

  function validateDOB(){
    var dob = document.getElementById("dob").value;
    if(!IsADate(dob)){
      document.getElementById("dob").classList.add('is-invalid');
			document.getElementById("dob").classList.remove('is-valid');
			document.getElementById("invaliddob").style.display = "block";
			document.getElementById("invaliddob").style.color = "red";
			document.getElementById("invaliddob").innerHTML = "Invalid Date of Birth";
    }
    else{
      document.getElementById("dob").classList.remove('is-invalid');
      document.getElementById("dob").classList.add('is-valid');
      document.getElementById("invaliddob").style.display = "block";
      document.getElementById("invaliddob").innerHTML = "Valid Date of Birth";
      document.getElementById("invaliddob").style.color = "green";
    }
    finalCheck2();
  }

  function validateAddress(){
    var address = document.getElementById("address").value;
    if(address.length<5){
      document.getElementById("address").classList.add('is-invalid');
			document.getElementById("address").classList.remove('is-valid');
			document.getElementById("invalidaddress").style.display = "block";
			document.getElementById("invalidaddress").style.color = "red";
			document.getElementById("invalidaddress").innerHTML = "Invalid Address Format";
    }
    else{
      document.getElementById("address").classList.remove('is-invalid');
      document.getElementById("address").classList.add('is-valid');
      document.getElementById("invalidaddress").style.display = "block";
      document.getElementById("invalidaddress").innerHTML = "Valid Address Format";
      document.getElementById("invalidaddress").style.color = "green";
    }
    finalCheck2();
  }

  function validatePhone(){
    var phone = document.getElementById("phonenum").value;
    var maintainplus = '';
    var numval = phone;
    if ( numval.charAt(0)=='+' )
    {
        var maintainplus = '';
    }
    curphonevar = numval.replace(/[\\ A-Za-z!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g,'');
    document.getElementById("phonenum").value = maintainplus + curphonevar;
    var maintainplus = '';

    if(phone.length!=8){
      document.getElementById("phonenum").classList.add('is-invalid');
			document.getElementById("phonenum").classList.remove('is-valid');
			document.getElementById("invalidphone").style.display = "block";
			document.getElementById("invalidphone").style.color = "red";
			document.getElementById("invalidphone").innerHTML = "Invalid Phone Number";
    }
    else{
      document.getElementById("phonenum").classList.remove('is-invalid');
      document.getElementById("phonenum").classList.add('is-valid');
      document.getElementById("invalidphone").style.display = "block";
      document.getElementById("invalidphone").innerHTML = "Valid Phone Number";
      document.getElementById("invalidphone").style.color = "green";
    }
    finalCheck2();
  }

  function valiateDistrict(){
    var sd = document.getElementById("district").selectedIndex;
  	if( sd == 0){
      document.getElementById("district").classList.add('is-invalid');
			document.getElementById("district").classList.remove('is-valid');
			document.getElementById("invaliddistrict").style.display = "block";
			document.getElementById("invaliddistrict").style.color = "red";
			document.getElementById("invaliddistrict").innerHTML = "Invalid District";
  	}
  	else{
      document.getElementById("district").classList.remove('is-invalid');
      document.getElementById("district").classList.add('is-valid');
      document.getElementById("invaliddistrict").style.display = "block";
      document.getElementById("invaliddistrict").innerHTML = "Valid District";
      document.getElementById("invaliddistrict").style.color = "green";
  	}
    finalCheck2();
  }

  function valiateGender(){
    var sd = document.getElementById("gender").selectedIndex;
  	if( sd == 0){
      document.getElementById("gender").classList.add('is-invalid');
			document.getElementById("gender").classList.remove('is-valid');
			document.getElementById("invalidgender").style.display = "block";
			document.getElementById("invalidgender").style.color = "red";
			document.getElementById("invalidgender").innerHTML = "Invalid Gender";
  	}
  	else{
      document.getElementById("gender").classList.remove('is-invalid');
      document.getElementById("gender").classList.add('is-valid');
      document.getElementById("invalidgender").style.display = "block";
      document.getElementById("invalidgender").innerHTML = "Valid Gender";
      document.getElementById("invalidgender").style.color = "green";
  	}
    finalCheck2();
  }

  function IsADate(dob){
    var d = new Date(dob);
    var today = new Date();
    var dY = d.getFullYear();
    var dM = d.getMonth()+1;
    var dD = d.getDate();
    var todayY = today.getFullYear();
    var todayM = today.getMonth()+1;
    var todayD = today.getDate();
    if(dY==todayY){
    	if(dM==todayM){
        	if(dD==todayD){
          	return false;
          }
          else if(dD<todayD){
            return true;
          }
          else{
          	return false;
          }
        }
        else if(dM<todayM){
        	return true;
        }
    	else{
          return false;
        }
    }
    else if(dY<todayY){
      return true;
    }
    else{
      return false;
    }
  }

  function IsHKID(str) {
      var strValidChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      // basic check length
      if (str.length < 8)
          return false;
      if (str.charAt(str.length-3) == '(' && str.charAt(str.length-1) == ')')
          str = str.substring(0, str.length - 3) + str.charAt(str.length -2);
      str = str.toUpperCase();
      var hkidPat = /^([A-Z]{1,2})([0-9]{6})([A0-9])$/;
      var matchArray = str.match(hkidPat);
      if (matchArray == null)
          return false;
      var charPart = matchArray[1];
      var numPart = matchArray[2];
      var checkDigit = matchArray[3];
      var checkSum = 0;
      if (charPart.length == 2) {
          checkSum += 9 * (10 + strValidChars.indexOf(charPart.charAt(0)));
          checkSum += 8 * (10 + strValidChars.indexOf(charPart.charAt(1)));
      } else {
          checkSum += 9 * 36;
          checkSum += 8 * (10 + strValidChars.indexOf(charPart));
      }
      for (var i = 0, j = 7; i < numPart.length; i++, j--)
          checkSum += j * numPart.charAt(i);
      var remaining = checkSum % 11;
      var verify = remaining == 0 ? 0 : 11 - remaining;
      return verify == checkDigit || (verify == 10 && checkDigit == 'A');
  }

  function finalCheck2(){
    var hkid =  document.getElementById("hkid").classList.contains('is-valid');
    var dob = document.getElementById("dob").classList.contains('is-valid');
    var address = document.getElementById("address").classList.contains('is-valid');
    var district = document.getElementById("district").classList.contains('is-valid');
    var phonenum = document.getElementById("phonenum").classList.contains('is-valid');
    var gender = document.getElementById("gender").classList.contains('is-valid');
    if(hkid&&dob&&address&&district&&phonenum&&gender){
      document.getElementById("submit2").disabled = false;
    }
    else{
      document.getElementById("submit2").disabled = true;
    }
  }


  </script>
</body>
</html>
