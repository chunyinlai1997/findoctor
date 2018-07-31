<?php
	include_once 'config.php';
	include_once 'token.php';
	$v = notVerified();
	if($v){
		header('Location:account_issue');
	}
?>
<html lang="en">

<head>
	<title>Home -- Doctor Appointment System -- Findoctor</title>
	<?php include 'head-info.php';
	?>

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
	<!-- End Preload -->
	<main>
		<div class="hero_home version_1">
			<div class="content">
				<h3 style="padding-top:30px;">Find a Doctor!</h3>
				<p>
					Select the followings, we will find the doctor that suits you.
				</p>
				</br>

					<div class="container">
						<div class="row justify-content-lg-center">
						<form action="action_search.php" method="post">
							<div class="row">
							  <div class="col-lg-6">
							    <div class="input-group">
										<label for='district' class='col-12 col-form-label'>District</label>
										<select class='form-control' name='district' id='district'>
											<option selected value="All">All District</option>
											<option disabled='true'>--Hong Kong Island--</option>
											<option disabled='true'></option>
											<option value='Eastern District'>Eastern District 東區 </option>
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
											<option value='Tai Po District'>Tai Po District 大埔 </option>
											<option value='Tsuen Wan District'>Tsuen Wan District 荃灣 </option>
											<option value='Tuen Mun District'>Tuen Mun District 屯門 </option>
											<option value='Yuen Long District'>Yuen Long District 元朗</option>
										</select>

							    </div>
							  </div>
							  <div class="col-lg-6">
							    <div class="input-group">
										<label for='specialization' class='col-12 col-form-label'>Specialization</label>
										<select class='form-control' name='specialization' id='specialization'>
											<option selected value="All">All Specialization</option>
											<option value='Primary Care'>Primary Care</option>
											<option value='Cardiology'>Cardiology</option>
											<option value='MRI Resonance'>MRI Resonance</option>
											<option value='Blood test'>Blood test</option>
											<option value='Laboratory'>Laboratory</option>
											<option value='Dentistry'>Dentistry</option>
											<option value='X - Ray'>X - Ray</option>
											<option value='Piscologist'>Piscologist</option>
										</select>

							    </div>
							  </div>
							</div>
							<br>
							<div class="row">
							  <div class="col-lg-offset-3 col-lg-6">
							    <div class="input-group">
										<label for='date' class='col-12 col-form-label'>Pick a day</label>
										<input class='form-control' id="date" name="date" type="date">
							    </div>
							  </div>
								<div class="col-lg-6">
							    <div class="input-group">
										<label for='timeslot' class='col-12 col-form-label'>Timeslot</label>
										<select class='form-control' name='timeslot' id='timeslot'>
											<option selected value="All">All Timeslot</option>
											<option value='Morning'>Morning</option>
											<option value='Afternoon'>Afternoon</option>
											<option value='Night'>Night</option>
										</select>
							    </div>
							  </div>
							</div>
							</br></br>
							<p class="text-center"><button type='submit' name="Search" id="Search" value="Search" class="btn_1 medium">Search</button></p>
						</form>

					</div>
				</div>
			</div>
		</div>
		<!-- /Hero -->
		<script>
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!

		var yyyy = today.getFullYear();
		if(dd<10){
				dd='0'+dd;
		}
		if(mm<10){
				mm='0'+mm;
		}
		var someDate = new Date();
		var numberOfDaysToAdd = 14;
		someDate.setDate(someDate.getDate() + numberOfDaysToAdd);

		var sdd = someDate.getDate();
		var smm = someDate.getMonth() + 1;
		var sy = someDate.getFullYear();

		if(sdd<10){
				sdd='0'+sdd;
		}
		if(smm<10){
				smm='0'+smm;
		}
		someDate=sy+'-'+smm+'-'+sdd;
		document.getElementsByName("date")[0].setAttribute('max', someDate);
		today = yyyy+'-'+mm+'-'+dd;
		document.getElementsByName("date")[0].setAttribute('min', today);
		</script>


		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Discover the <strong>online</strong> appointment!</h2>
				<p>Make an appointment within 3 simple steps.</p>
			</div>
			<div class="row add_bottom_30">
				<div class="col-lg-4">
					<div class="box_feat" id="icon_1">
						<span></span>
						<h3>Find a Doctor</h3>
						<p>Find a doctor by telling us your requirements. Then, we will provide a list of doctors that meet your requirements.</p>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box_feat" id="icon_2">
						<span></span>
						<h3>View profile</h3>
						<p>You could view the profile of those recommended doctors, and select the one you like.</p></br>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box_feat" id="icon_3">
						<h3>Book a visit</h3>
						<p>Lastly, make an appointment by inputting some basic information about yourself.</p></br>
					</div>
				</div>
			</div>
			<!-- /row -->
			<p class="text-center"><a href="./list.html" class="btn_1 medium">Find Doctor</a></p>

		</div>
		<!-- /container -->

		<div class="bg_color_1">
			<div class="container margin_120_95">
				<div class="main_title">
					<h2>Most Viewed doctors</h2>
					<p>Check out the doctors that our visitors viewed most.</p>
				</div>
				<div id="reccomended" class="owl-carousel owl-theme">
					<div class="item">
						<a href="./detail-page.html">
							<div class="views"><i class="icon-eye-7"></i>140</div>
							<div class="title">
								<h4>Dr. Julia Holmes<em>Pediatrician - Cardiologist</em></h4>
							</div><img src="./img/doctor_1_carousel.jpg" alt="" />
						</a>
					</div>
					<div class="item">
						<a href="./detail-page.html">
							<div class="views"><i class="icon-eye-7"></i>120</div>
							<div class="title">
								<h4>Dr. Julia Holmes<em>Pediatrician</em></h4>
							</div><img src="./img/doctor_2_carousel.jpg" alt="" />
						</a>
					</div>
					<div class="item">
						<a href="./detail-page.html">
							<div class="views"><i class="icon-eye-7"></i>115</div>
							<div class="title">
								<h4>Dr. Julia Holmes<em>Pediatrician</em></h4>
							</div><img src="./img/doctor_3_carousel.jpg" alt="" />
						</a>
					</div>
					<div class="item">
						<a href="./detail-page.html">
							<div class="views"><i class="icon-eye-7"></i>98</div>
							<div class="title">
								<h4>Dr. Julia Holmes<em>Pediatrician</em></h4>
							</div><img src="./img/doctor_4_carousel.jpg" alt="" />
						</a>
					</div>
					<div class="item">
						<a href="./detail-page.html">
							<div class="views"><i class="icon-eye-7"></i>98</div>
							<div class="title">
								<h4>Dr. Julia Holmes<em>Pediatrician</em></h4>
							</div><img src="./img/doctor_5_carousel.jpg" alt="" />
						</a>
					</div>
				</div>
				<!-- /carousel -->
			</div>
			<!-- /container -->
		</div>
		<!-- /white_bg -->

		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Find by specialization</h2>
				<p></p>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<a href="action_search?Search=true&specialization=Primary Care" class="box_cat_home">
						<i class="icon-info-4"></i>
						<img src="./img/icon_cat_1.svg" width="60" height="60" alt="" />
						<h3>Primary Care</h3>
						<ul class="clearfix">
							<li><strong>124</strong>Doctors</li>
							<li><strong>30</strong>Clinics</li>
						</ul>
					</a>
				</div>
				<div class="col-lg-3 col-md-6">
					<a href="action_search?Search=true&specialization=Cardiology" class="box_cat_home">
						<i class="icon-info-4"></i>
						<img src="./img/icon_cat_2.svg" width="60" height="60" alt="" />
						<h3>Cardiology</h3>
						<ul class="clearfix">
							<li><strong>124</strong>Doctors</li>
							<li><strong>30</strong>Clinics</li>
						</ul>
					</a>
				</div>
				<div class="col-lg-3 col-md-6">
					<a href="action_search?Search=true&specialization=MRI Resonance" class="box_cat_home">
						<i class="icon-info-4"></i>
						<img src="./img/icon_cat_3.svg" width="60" height="60" alt="" />
						<h3>MRI Resonance</h3>
						<ul class="clearfix">
							<li><strong>124</strong>Doctors</li>
							<li><strong>30</strong>Clinics</li>
						</ul>
					</a>
				</div>
				<div class="col-lg-3 col-md-6">
					<a href="action_search?Search=true&specialization=Blood test" class="box_cat_home">
						<i class="icon-info-4"></i>
						<img src="./img/icon_cat_4.svg" width="60" height="60" alt="" />
						<h3>Blood test</h3>
						<ul class="clearfix">
							<li><strong>124</strong>Doctors</li>
							<li><strong>30</strong>Clinics</li>
						</ul>
					</a>
				</div>
				<div class="col-lg-3 col-md-6">
					<a href="action_search?Search=true&specialization=Laboratory" class="box_cat_home">
						<i class="icon-info-4"></i>
						<img src="./img/icon_cat_7.svg" width="60" height="60" alt="" />
						<h3>Laboratory</h3>
						<ul class="clearfix">
							<li><strong>124</strong>Doctors</li>
							<li><strong>30</strong>Clinics</li>
						</ul>
					</a>
				</div>
				<div class="col-lg-3 col-md-6">
					<a href="action_search?Search=true&specialization=Dentistry" class="box_cat_home">
						<i class="icon-info-4"></i>
						<img src="./img/icon_cat_5.svg" width="60" height="60" alt="" />
						<h3>Dentistry</h3>
						<ul class="clearfix">
							<li><strong>124</strong>Doctors</li>
							<li><strong>30</strong>Clinics</li>
						</ul>
					</a>
				</div>
				<div class="col-lg-3 col-md-6">
					<a href="action_search?Search=true&specialization=X - Ray" class="box_cat_home">
						<i class="icon-info-4"></i>
						<img src="./img/icon_cat_6.svg" width="60" height="60" alt="" />
						<h3>X - Ray</h3>
						<ul class="clearfix">
							<li><strong>124</strong>Doctors</li>
							<li><strong>30</strong>Clinics</li>
						</ul>
					</a>
				</div>
				<div class="col-lg-3 col-md-6">
					<a href="action_search?Search=true&specialization=Piscologist" class="box_cat_home">
						<i class="icon-info-4"></i>
						<img src="./img/icon_cat_8.svg" width="60" height="60" alt="" />
						<h3>Piscologist</h3>
						<ul class="clearfix">
							<li><strong>124</strong>Doctors</li>
							<li><strong>30</strong>Clinics</li>
						</ul>
					</a>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</main>
	<div class="bg_color_1">
		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Branches in Hong Kong</h2>
				<p>No.1 leader of chain clinic service</p>
			</div>
			<?php include 'map.php';	?>

 		</div>
	</div>

	<p class="text-center"><a href="./aboutus.php" class="btn_1 medium">Know more about Findoctor</a></p>
	<script>




  function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        request.onreadystatechange = doNothing;
        callback(request, request.status);
      }
    };

    request.open('GET', url, true);
    request.send(null);
  }

  function doNothing() {}
	</script>
	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLZsnuumGUJMP07RAhSrly-wSezRXi19U&callback=initMap">
	</script>
	<!-- /main content -->
	<?php include 'footer.php';?>

	<?php include 'member_modal.php';?>

	<div id="toTop"></div>
	<!-- Back to top button -->

	<!-- COMMON SCRIPTS
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	-->
	<script src="./js/jquery-2.2.4.min.js"></script>
	<script src="./js/common_scripts.min.js"></script>
	<script src="./js/functions.js"></script>
	<script src="./js/header.js"></script>
</body>

</html>
