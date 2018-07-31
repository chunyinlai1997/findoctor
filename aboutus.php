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
	<title>About Us -- Doctor Appointment System -- Findoctor</title>
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
		<img src="./img/banner1.jpg" width="100%" align="middle">
		<div class="container margin_120_95">
		<div class="main_title">
			<h2>How?</h2>
		</div>
		
		
			<div class="col-lg-12">
				<div class="box_feat" style="padding-top:30px;">
				<img src="./img/questionmark_3.png" width="150px" height="150px" align="middle">
					<h3 style="color:#00a98f;">How do you find doctors and make appointments?</h3>
					<p>Search in Google, and visit site by site? Or ask for your friends' recommendations? 
					Then, search for the clinic's phone number and make an appointment by phone? These ways 
					could not easily help to find a doctor that suits you, and they are time consuming and not effective. But 
					with Findoctor, you could find doctors, make appointments and even manage your 
					appointments in one single website. Interesting?</p>
				</div>
			</div>
		</div>
		
		
		<img src="./img/banner2.jpg" width="100%" align="middle">
		
		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Discover the <strong>3 main services</strong> in Findoctor</h2>
			</div>
			<div class="row add_bottom_30">
				<div class="col-lg-12">
					<div class="box_feat" id="icon_1">
						<h3>Find a Doctor</h3>
						<p>Findoctor helps you to find the doctors that meet your requirements, no matters 
						what locations, specializations, date and time. Findoctor will provide you with the 
						best options that meet your requirement. So you could find a suitable doctor easily 
						in one single website.</p>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="box_feat" id="icon_3">
						<h3>Make appointment</h3>
						<p>After choosing a doctor, you could make the appointment in Findoctor. Findoctor 
						would pass your appointment details to the related clinic. So no phone calls 
						appointment anymore.</p>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="box_feat" id="icon_2">
						<h3>Management appointment</h3>
						<p>You could manage your appointments at any time in Findoctor. Findoctor would 
						update your new appointments details to the related clinic. You could also see the 
						specialization, date, time and location of your upcoming appointments. We would 
						also remind you before the day of your appointments. Findoctor also allows you to 
						check your record of past appointments.</p>
					</div>
				</div>
			</div>
		</div>
		
		<img src="./img/banner5.jpg" width="100%" align="middle">
		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Users</h2>
				<p>Findoctor supports both patients and clinic staffs</p>
			</div>
			<div class="row add_bottom_30">
				<div class="col-lg-6">
					<div class="box_feat" style="padding-top:30px;">
					<img src="./img/patient_m.png" width="150px" height="150px" align="middle" style="padding:5px;">
					<img src="./img/patient_f.png" width="150px" height="150px" align="middle" style="padding:5px;">
						<h3>Patients</h3>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box_feat" style="padding-top:30px;">
					<img src="./img/doctor.png" width="150px" height="150px" align="middle" style="padding:5px;">
					<img src="./img/nurse.png" width="150px" height="150px" align="middle" style="padding:5px;">
						<h3>Doctors / Nurses</h3>
					</div>
				</div>
			</div>
		</div>
		
		<img src="./img/banner8.png" width="100%" align="middle">
		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Over 50 Clinics in Hong Kong</h2>
			</div>
			<?php include'map.php';?>
		</div>
		
		<p class="text-center" style="padding-bottom:80px;"><a href="./index.php" class="btn_1 medium">Findoctor NOW!</a></p>
	</main>
	
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
	
	<script src="./js/jquery-2.2.4.min.js"></script>
	<script src="./js/common_scripts.min.js"></script>
	<script src="./js/functions.js"></script>
	<script src="./js/header.js"></script>
	
</body>

</html>
