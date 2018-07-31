<?php
  include_once 'config.php';
  include_once 'token.php';
  $id = isLoggedin();
  if(!$id){
    header("Location:login");
  }
  $v = notVerified();
  if($v){
  	header('Location:account_issue');
  }
  $r = getRole();
  if($r!="patient"){
    header("Location:staff_login");
  }

  $greet="";
  $complete = 0;
  $complete2  = 0;
  $sql = mysql_query("SELECT Users.firstname,Users.lastname,Users.email,Users.role,Users.profile_image,Users.join_date,Users.phone,Patient.date_of_birth,Patient.address,Patient.district,Patient.hkid,Patient.gender FROM Users, Patient WHERE Users.id = '$id' AND Users.id = Patient.user_id ");
  $result = mysql_fetch_array($sql,MYSQL_NUM);
  $firstanme = $result[0];
  $lastname = $result[1];
  $email = $result[2];
  $role = $result[3];
  $profile_image = $result[4];
  $join_date = $result[5];
  $phone = $result[6];
  $dob = $result[7];
  $address = $result[8];
  $district = $result[9];
  $hkid = $result[10];
  $gender = $result[11];


  $date = new DateTime($dob);
  $now = new DateTime();
  $interval = $now->diff($date);
  $age  =  $interval->y;

  if($gender="M"){
    $genderP = "Male";
  }
  else if($gender="F"){
    $genderP = "Female";
  }
  else{
    $genderP = "Unclassified";
  }

  function isD($d){
    $id = isLoggedin();
    $sql2 = mysql_query("SELECT Patient.district FROM Patient WHERE Patient.user_id = '$id'");
    $result = mysql_fetch_array($sql2,MYSQL_NUM);
    if($d==$result[0]){
      return "selected";
    }
    else{
      return " ";
    }
  }

  function isG($g){
    $id = isLoggedin();
    $sql2 = mysql_query("SELECT Patient.gender FROM Patient WHERE Patient.user_id = '$id'");
    $result = mysql_fetch_array($sql2,MYSQL_NUM);
    if($g==$result[0]){
      return "selected";
    }
    else{
      return " ";
    }
  }

  if(isset($_POST['submit2']) && !empty($_POST['submit2'])){
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
        //your site secret key
        $secret = '6LcN5jQUAAAAACa2GtQVN-n7lw3gLgu6RDMCoufK';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){
          if(isset($_POST['submit2'])){
            $id = isloggedin();
            $phone =  $_POST['phone'];
            $gender =  $_POST['gender'];
            $address =  $_POST['address'];
            $district =  $_POST['district'];
            mysql_query("UPDATE Users SET phone='$phone' WHERE id='$id'");
            mysql_query("UPDATE Patient SET address='$address',district='$district',gender='$gender' WHERE user_id='$id'");
            $complete = 1;
          }
        }
        else{
            header('Location:personal_info?ac=wrong');
        }
    }
    else{
        header('Location:personal_info?ac=wrong');
    }
  }

  if (isset($_POST['submit3']) && !empty($_POST['submit3'])){
	  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
		//your site secret key
        $secret = '6LcN5jQUAAAAACa2GtQVN-n7lw3gLgu6RDMCoufK';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success){
          if(isset($_POST['submit3'])){
            $id = isloggedin();
            $new1 =  $_POST['password1'];
			$hashed_password = password_hash("$new1", PASSWORD_DEFAULT);
            mysql_query("UPDATE Users SET password='$hashed_password' WHERE id='$id'");
		    $complete2 = 1;
		  }
		}
		else{
			header('Location:personal_info?ac=wrong');
		}
	  }
	  else{
        header('Location:personal_info?ac=wrong');
      }
  }

?>

<html lang="en">

<head>
	<title> Personal Info --Doctor Appointment System --  ABC Medical Company</title>
	<?php include 'head-info.php';
	?>
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>

<body>
  <div id="headprint">
    <?php
      include 'header.php';
      gen_header();
    ?>
  </div>
  <div class="layer"></div>
  <!-- Mobile menu overlay mask -->
  <div id="preloader">
    <div data-loader="circle-side"></div>
  </div>


	<main>
		<div id="breadcrumb">
			<div class="container">
				<ul>
					<li><a href="index">Home</a></li>
					<li><a href="#">Profile</a></li>
					<li>Personal Info Page</li>
				</ul>
			</div>
		</div>
		<!-- /breadcrumb -->
		<div class="container margin_60">
			<div class="row">
				<aside class="col-xl-3 col-lg-4" id="sidebar">
					<div class="box_profile">
						<figure>
							<img src="<?php echo $profile_image;?>" alt="" class="img-fluid" />
						</figure>
						<!---->
						<h1><?php echo $firstanme." ".$lastname;?></h1>

						<!--<span class="rating">
							<i class="icon_star voted"></i>
							<i class="icon_star voted"></i>
							<i class="icon_star voted"></i>
							<i class="icon_star voted"></i>
							<i class="icon_star"></i>
							<small>(145)</small>
							<a href="./badges.html" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="./img/badges/badge_1.svg" width="15" height="15" alt="" /></a>
						</span>-->
						<ul class="statistic">
							<li><?php echo $genderP; ?></li>
							<li><?php echo $age; ?> yrs old</li>
						</ul>
            <small>since <?php echo $join_date;?></small>
						<ul class="contacts">
              <li><h6>Registered Email</h6><?php echo $email; ?></li>
							<li><h6>Address</h6><?php echo $address; ?></li>
              <li><h6>District</h6><?php echo $district; ?></li>
							<li><h6>Phone</h6><a href="tel://<?php echo $phone; ?>"><?php echo $phone; ?></a></li>
						</ul>
						<div class="text-center"><a href="discover" class="btn_1 outline" target="_blank"><i class="icon_pin"></i>Find Nearest Clinic</a></div>
					</div>
				</aside>
				<!-- /asdide -->

				<div class="col-xl-9 col-lg-8">

					<div class="tabs_styled_2">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#changeprofile" role="tab" aria-controls="changeprofile">Change Personal Info</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="password-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-expanded="true">Change Password</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="privacy-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews">Privacy</a>
							</li>
						</ul>
						<!--/nav-tabs -->

						<div class="tab-content">

							<div class="tab-pane fade show active" id="changeprofile" role="tabpanel" aria-labelledby="profile-tab">
                <?php
                if($complete==1){
                  echo "<div class='alert alert-success' role='alert'><strong>Well done!</strong> You have successfully updated your personal info.<button type='button' class='close' data-dismiss='alert' aria-label='Close'></div>";
                }
				if($complete2==1){
                  echo "<div class='alert alert-success' role='alert'><strong>Well done!</strong> You have successfully updated your password.<button type='button' class='close' data-dismiss='alert' aria-label='Close'></div>";
                }
                ?>
                <p>You can update your personal information here.</p>
                <div class='container margin_10_10'>
                  <div class='row'>
                    <div class='col-12 ml-auto'>
                      <div class='box_form'>
                        <form action='personal_info' method='POST'>
                          <div class='row'>
                            <div class='col-md-6 '>
                              <div class='form-group'>
                                <label for='hkid' class='col-12 col-form-label'>First Name</label>
                                <input type='text' id='firstname' name='firstname' class='form-control' value='<?php echo $firstanme;?>' disabled/>
                                <div id='invalidhkid' class='invalid-feedback' style='display:none;'></div>
                              </div>
                            </div>
                            <div class='col-md-6'>
                              <div class='form-group row'>
                              <label for='hkid' class='col-12 col-form-label'>Last Name</label>
                              <input class='form-control' type='text' name='lastname' id='lastname' value='<?php echo $lastname;?>' disabled />
                              <div id='invaliddob' class='invalid-feedback' style='display:none;'></div>
                              </div>
                              </div>
                          </div>
                          <div class='row'>
                            <div class='col-md-6 '>
                              <div class='form-group'>
                                <label for='hkid' class='col-12 col-form-label'>HKID</label>
                                <input type='text' id='hkid' value='<?php echo $hkid;?>' name='hkid' class='form-control'  disabled/>
                                <div id='invalidhkid' class='invalid-feedback' style='display:none;'></div>
                              </div>
                            </div>
                            <div class='col-md-6'>
                              <div class='form-group row'>
                              <label for='hkid' class='col-12 col-form-label'>Date of Birth</label>
                              <input class='form-control'  type='date' name='dob' id='dob' value='<?php echo $dob;?>' disabled />
                              <div id='invaliddob' class='invalid-feedback' style='display:none;'></div>
                              </div>
                              </div>
                          </div>
                          <!-- /row -->
                          <div class='row'>
                            <div class='col-lg-12'>
                              <div class='form-group'>
                                <label for='address' class='col-12 col-form-label'>Address</label>
                                <input type='text' minlength='5' onkeyup='validateAddress()' name='address' id='address' value='<?php echo $address;?>' class='form-control' placeholder='Your Address' required/>
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
                                <option disabled hidden>District</option>
                                <option disabled='true'>--Hong Kong Island--</option>
                                <option disabled='true'></option>
                                <option value='Central & Western District' <?php echo isD("Central & Western District");?>>Central & Western District 中西區 </option>
                                <option value='Eastern District' <?php echo isD("Central & Western District");?>>Eastern District 東區 </option>
                                <option value='Southern District' <?php echo isD("Southern District");?>>Southern District 南區 </option>
                                <option value='Wan Chai District' <?php echo isD("Wan Chai District");?>>Wan Chai District 灣仔 </option>
                                <option disabled='true'></option>
                                <option disabled='true'>--Kowloon--</option>
                                <option disabled='true'></option>
                                <option value='Kowloon City District' <?php echo isD("Kowloon City District");?>>Kowloon City District 九龍城 </option>
                                <option value='Kwun Tong District' <?php echo isD("Kwun Tong District");?>>Kwun Tong District 觀塘 </option>
                                <option value='Sham Shui Po District' <?php echo isD("Sham Shui Po District");?>>Sham Shui Po District 深水埗  </option>
                                <option value='Wong Tai Sin District' <?php echo isD("Wong Tai Sin District");?>> Wong Tai Sin District 黃大仙 </option>
                                <option value='Yau Tsim Mong District' <?php echo isD("Yau Tsim Mong District");?>>Yau Tsim Mong District 油尖旺  </option>
                                <option disabled='true'></option>
                                <option disabled='true'>--New Territories--</option>
                                <option disabled='true'></option>
                                <option value='Islands District' <?php echo isD("Islands District");?>> Islands District 離島 </option>
                                <option value='Kwai Tsing District' <?php echo isD("Kwai Tsing District");?>> Kwai Tsing District 葵青 </option>
                                <option value='North District ' <?php echo isD("North District");?>>North District 北區  </option>
                                <option value='Sai Kung District' <?php echo isD("Sai Kung District");?>>Sai Kung District 西貢 </option>
                                <option value='Sha Tin District' <?php echo isD("Sha Tin District");?>>Sha Tin District 沙田 </option>
                                <option value='Tai Po District' <?php echo isD("Tai Po District");?>>Tai Po District 大埔 </option>
                                <option value='Tsuen Wan District' <?php echo isD("Tsuen Wan District");?>>Tsuen Wan District 荃灣 </option>
                                <option value='Tuen Mun District' <?php echo isD("Tuen Mun District");?>>Tuen Mun District 屯門 </option>
                                <option value='Yuen Long District' <?php echo isD("Yuen Long District");?>>Yuen Long District 元朗</option>
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
                                <input type='text' name='phone' id='phonenum' onkeyup='validatePhone(this)' value='<?php echo $phone;?>' minlength='8' maxlength='8' class='form-control' placeholder='Your mobile phone' required/>
                                <div id='invalidphone' class='invalid-feedback' style='display:none;'></div>
                              </div>
                            </div>
                            <div class='col-md-6'>
                              <div class='form-group'>
                                <label for='gender' class='col-12 col-form-label'>Gender</label>
                                <select class='form-control' onchange='valiateGender()' name='gender' id='gender' required>
                                  <option value='M' <?php echo isG("M");?>>M
                                  <option value='F' <?php echo isG("F");?>>F
                                  <option value='Other' <?php echo isG("Other");?>>Other
                                </select>
                                <div id='invalidgender' class='invalid-feedback' style='display:none;'></div>
                              </div>
                            </div>
                          </div>
                          <!-- /row -->
                          <div class='row'>
                            <div class='col-md-6'>
                              <div class='form-group'>
                                <label for='confirm' class='col-12 col-form-label'>Password</label>
                                <input type='password' name='confirm' id='confirm' class='form-control' placeholder='Input your password' required/>
                                <div id='invalidconfirm' class='invalid-feedback' style='display:none;'></div>
                              </div>
                            </div>
                            <div class='col-md-6'>
                              <div class='form-group'>
                                <div class="recaptcha g-recaptcha" data-sitekey="6LcN5jQUAAAAAIHtiXMKYDvCGvfmu0OVothxYUBc"></div>
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
							<!-- /tab_1 -->

							<div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="password-tab">

								<div class='container margin_10_10'>
                  <div class='row'>
                    <div class='col-12 ml-auto'>
                      <div class='box_form'>
                        <form action='personal_info' method='POST'>
                          <!-- /row -->
                          <div class='row'>
                            <div class='col-md-6'>
                              <div class='form-group'>
                                <label for='oldPW' class='col-12 col-form-label'>Old Password</label>
                                <input type='password' name='oldPW' id='oldPW' class='form-control' placeholder='Input your old password' required/>
                                <div id='invalidconfirm2' class='invalid-feedback' style='display:none;'></div>
                              </div>
                            </div>
							<div class='col-md-6'>
                              <div class="form-group">
								<label>New Password</label>
								<input type="password" name="password1" class="form-control" id="password1" onkeyup="validatePass(this.value)" placeholder="Your new password" minlength="6" required />
								<div id="invalidPassword1" class="invalid-feedback" style="display:none;"></div>
							  </div>
                            </div>
						</div>
						<div class='row'>
						  <div class='col-md-6'>
							<div class="form-group">
								<label>Confirm new password</label>
								<input type="password" name="password2" class="form-control" id="password2" onkeyup="checkPass(this)" placeholder="Confirm new password" minlength="6" required/>
								<div id="invalidPassword2" class="invalid-feedback" style="display:none;"></div>
							</div>
						  </div>
                            <div class='col-md-6'>
                              <div class='form-group'>
                                <div class="recaptcha g-recaptcha" data-sitekey="6LcN5jQUAAAAAIHtiXMKYDvCGvfmu0OVothxYUBc"></div>
                              </div>
                            </div>
                          </div>
                          <!-- /row -->
                          <p class='text-center add_top_30'><input type='submit' class='btn_1' value='submit' name='submit3' id='submit3' disabled /></p>
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
							<!-- /tab_2 -->

							<div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="privacy-tab">
								<div class="reviews-container">
									<div class="row">
										<div class="col-lg-3">
											<div id="review_summary">
												<strong>4.7</strong>
												<div class="rating">
													<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
												</div>
												<small>Based on 4 reviews</small>
											</div>
										</div>
										<div class="col-lg-9">
											<div class="row">
												<div class="col-lg-10 col-9">
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-lg-2 col-3"><small><strong>5 stars</strong></small></div>
											</div>
											<!-- /row -->
											<div class="row">
												<div class="col-lg-10 col-9">
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-lg-2 col-3"><small><strong>4 stars</strong></small></div>
											</div>
											<!-- /row -->
											<div class="row">
												<div class="col-lg-10 col-9">
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-lg-2 col-3"><small><strong>3 stars</strong></small></div>
											</div>
											<!-- /row -->
											<div class="row">
												<div class="col-lg-10 col-9">
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-lg-2 col-3"><small><strong>2 stars</strong></small></div>
											</div>
											<!-- /row -->
											<div class="row">
												<div class="col-lg-10 col-9">
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-lg-2 col-3"><small><strong>1 stars</strong></small></div>
											</div>
											<!-- /row -->
										</div>
									</div>
									<!-- /row -->

									<hr />

									<div class="review-box clearfix">
										<figure class="rev-thumb"><img src="./img/avatar1.jpg" alt="" />
										</figure>
										<div class="rev-content">
											<div class="rating">
												<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
											</div>
											<div class="rev-info">
												Admin – April 03, 2016:
											</div>
											<div class="rev-text">
												<p>
													Sed eget turpis a pede tempor malesuada. Vivamus quis mi at leo pulvinar hendrerit. Cum sociis natoque penatibus et magnis dis
												</p>
											</div>
										</div>
									</div>
									<!-- /review-box -->

									<div class="review-box clearfix">
										<figure class="rev-thumb"><img src="./img/avatar2.jpg" alt="" />
										</figure>
										<div class="rev-content">
											<div class="rating">
												<i class="icon-star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
											</div>
											<div class="rev-info">
												Ahsan – April 01, 2016
											</div>
											<div class="rev-text">
												<p>
													Sed eget turpis a pede tempor malesuada. Vivamus quis mi at leo pulvinar hendrerit. Cum sociis natoque penatibus et magnis dis
												</p>
											</div>
										</div>
									</div>
									<!-- End review-box -->

									<div class="review-box clearfix">
										<figure class="rev-thumb"><img src="./img/avatar3.jpg" alt="" />
										</figure>
										<div class="rev-content">
											<div class="rating">
												<i class="icon-star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
											</div>
											<div class="rev-info">
												Sara – March 31, 2016
											</div>
											<div class="rev-text">
												<p>
													Sed eget turpis a pede tempor malesuada. Vivamus quis mi at leo pulvinar hendrerit. Cum sociis natoque penatibus et magnis dis
												</p>
											</div>
										</div>
									</div>
									<!-- End review-box -->

								</div>
								<!-- End review-container -->
							</div>
							<!-- /tab_3 -->
						</div>
						<!-- /tab-content -->
					</div>
					<!-- /tabs_styled -->
				</div>
				<!-- /col -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</main>
	<!-- /main -->

	<?php include 'footer.php';?>

	<div id="toTop"></div>
	<!-- Back to top button -->

	<!-- COMMON SCRIPTS -->
	<script src="../cdn-cgi/scripts/84a23a00/cloudflare-static/email-decode.min.js"></script><script src="./js/jquery-2.2.4.min.js"></script>
	<script src="./js/common_scripts.min.js"></script>
	<script src="./js/functions.js"></script>
  <script>
  $(document).ready(function () {
		$("#submit2" ).click(function(e) {
			if(grecaptcha.getResponse() == "") {
				e.preventDefault();
				alert("Captcha is Missing!");
			}
		});

    $('#confirm').change(function(){
			var pass = $(this).val();
			$.ajax({
				url:"check.php",
				method:"POST",
				data:{checkPass:pass},
				dataType:"text",
				success:function(response){
					if(response){
						$('#invalidconfirm').css("color","green");
						$('#invalidconfirm').css("display", "block");
						$('#invalidconfirm').html("Correct Password");
						$('#confirm').removeClass( "is-invalid" ).addClass( "is-valid" );
					}
					else{
						$('#invalidconfirm').css("color","red");
						$('#invalidconfirm').css("display", "block");
						$('#invalidconfirm').html("Wrong Password");
						$('#confirm').removeClass( "is-valid" ).addClass( "is-invalid" );
					}
					finalCheck2();
				}
			});
		});

		$('#oldPW').change(function(){
			var pass = $(this).val();
			$.ajax({
				url:"check.php",
				method:"POST",
				data:{checkPass:pass},
				dataType:"text",
				success:function(response){
					if(response){
						$('#invalidconfirm2').css("color","green");
						$('#invalidconfirm2').css("display", "block");
						$('#invalidconfirm2').html("Correct Password");
						$('#oldPW').removeClass( "is-invalid" ).addClass( "is-valid" );
					}
					else{
						$('#invalidconfirm2').css("color","red");
						$('#invalidconfirm2').css("display", "block");
						$('#invalidconfirm2').html("Wrong Password");
						$('#oldPW').removeClass( "is-valid" ).addClass( "is-invalid" );
					}
					finalCheck3();
				}
			});
		});
	});

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

  function finalCheck2(){
    var address = document.getElementById("address").classList.contains('is-invalid');
    var district = document.getElementById("district").classList.contains('is-invalid');
    var phonenum = document.getElementById("phonenum").classList.contains('is-invalid');
    var gender = document.getElementById("gender").classList.contains('is-invalid');
    var confirm = document.getElementById("confirm").classList.contains('is-valid');
    if(!address&&!district&&!phonenum&&!gender&&confirm){
      document.getElementById("submit2").disabled = false;
    }
    else{
      document.getElementById("submit2").disabled = true;
    }
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
		finalCheck3();
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
		finalCheck3();
	}

	function finalCheck3(){
    var old = document.getElementById("oldPW").classList.contains('is-invalid');
    var new1 = document.getElementById("password1").classList.contains('is-invalid');
	var new2 = document.getElementById("password2").classList.contains('is-invalid');
    if(!old&&!new1&&!new2){
      document.getElementById("submit3").disabled = false;
    }
    else{
      document.getElementById("submit3").disabled = true;
    }
  }
  </script>
	<!-- SPECIFIC SCRIPTS -->
  <script src="./js/bootstrap-datepicker.js"></script>
	<script>
		$('#calendar').datepicker({
			todayHighlight: true,
			daysOfWeekDisabled: [0],
			weekStart: 1,
			format: "yyyy-mm-dd",
			datesDisabled: ["2017/10/20", "2017/11/21", "2017/12/21", "2018/01/21", "2018/02/21", "2018/03/21"],
		});
	</script>

</body>
</html>
