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
	<title>Search -- Doctor Appointment System -- Findoctor</title>
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
