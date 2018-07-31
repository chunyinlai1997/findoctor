<?php
	include_once 'config.php';
	include_once 'token.php';
	include 'header.php';
	$v = notVerified();
	if($v){
		header('Location:account_issue');
	}
?>
<html lang="en">

<head>
	<title>Result Grid -- Doctor Appointment System -- Findoctor</title>
	<?php include 'head-info.php';
	?>
	<style>

	</style>
</head>

<body>
	<div id="headprint">
		<?php
		  gen_header();
		?>
	</div>
	<div class="layer"></div>

	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>

   <main>
		 <!--
	 <div id="results">
		 <div class="container">
			 <div class="row">
				 <div class="col-md-6">
					 <h4><strong>Showing 10</strong> of 140 results</h4>
				 </div>

				 <div class="col-md-6">
					 <div class="search_bar_list">
						 <input type="text" class="form-control" placeholder="Ex. Specialist, Name, Doctor..." />
						 <input type="submit" value="Search" />
					 </div>
				 </div>
			 </div>
			<!-- /row -->
		<!-- </div>-->
		<!-- /container -->
	<!-- </div>-->
 <!-- /results -->



   <div class="filters_listing">

	 <div class="container">
		 <form action="tmp.php" method="post">
			 <div class="row">
				 <div class="col-lg-3 col-md-6 col-6">
					 <div class="input-group">
						 <label for='district' class='col-12 col-form-label'>District</label>
						 <select class='form-control' name='district' id='district'>
							 <option selected disabled hidden>District</option>
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
				 <div class="col-lg-3 col-md-6 col-6">
					 <div class="input-group">
						 <label for='specialization' class='col-12 col-form-label'>Specialization</label>
						 <select class='form-control' name='specialization' id='specialization'>
							 <option selected disabled hidden>Specialization</option>
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
				 <div class="col-lg-3 col-md-6 col-6">
					 <div class="input-group">
						 <label for='date' class='col-12 col-form-label'>Pick a day</label>
						 <input class='form-control' id="date" name="date" type="date">
					 </div>
				 </div>
				 <div class="col-lg-3 col-md-6 col-6">
					 <div class="input-group">
						 <label for='timeslot' class='col-12 col-form-label'>Timeslot</label>
						 <select class='form-control' name='timeslot' id='timeslot'>
							 <option selected disabled hidden>Pick a Timeslot</option>
							 <option value='Morning'>Morning</option>
							 <option value='Afternoon'>Afternoon</option>
							 <option value='Night'>Night</option>
						 </select>
					 </div>
				 </div>
			 </div>
			 <br>
			 <div class="row">
			 <div class="col-md-6">
			 <button type='submit' name="Search" id="Search" value="Search" class="btn_1 medium">Search</button>
			 </div>
			</div>
		 </form>
	 </div>
<br><hr>
		<div class="container">
			<ul class="clearfix">
				<li>
					<h6>Type</h6>
					<div class="switch-field">
						<input type="radio" id="clinics" checked="" name="type_patient" value="clinics" />
						<label for="clinics">Clinics</label>
						<input type="radio" id="doctors" name="type_patient" value="doctors" />
						<label for="doctors">Doctors</label>
					</div>
				</li>
				<li>
					<h6>Layout</h6>
					<div class="layout_view">
						<a href="result"><i class="icon-th"></i></a>
						<a href="#0" class="active"><i class="icon-th-list"></i></a>
						<a href="result-map"><i class="icon-map-1"></i></a>
					</div>
				</li>
				<li>
					<h6>Sort by</h6>
					<select name="orderby" class="selectbox">
					<option value="Closest" />Closest
					<option value="Best rated" />Best rated
					<option value="Men" />Men
					<option value="Women" />Women
					</select>
				</li>
			</ul>
		</div>
		<!-- /container -->
	</div>
	<!-- /filters -->

	<div class="container margin_60_35">
		<div class="row">
			<div class="col-lg-8">
				<div class="row">
					<div class="col-md-6">
						<div class="box_list wow fadeIn">
							<a href="#0" class="wish_bt"></a>
							<figure>
								<a href="./detail-page.html"><img src="./img/doctor_listing_1.jpg" class="img-fluid" alt="" />
									<div class="preview"><span>Read more</span></div>
								</a>
							</figure>
							<div class="wrapper">
								<small>Psicologist</small>
								<h3>Dr. Sickman</h3>

								<p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cuodo....</p>
								<span class="rating"><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i><i class="icon_star"></i> <small>(145)</small></span>
								<a href="./badges.html" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="./img/badges/badge_1.svg" width="15" height="15" alt="" /></a>
							</div>
							<ul>
								<li><a href="#0" onclick="onHtmlClick('Doctors', 0)"><i class="icon_pin_alt"></i>View on map</a></li>
								<li><a href="https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x0:0xa6a9af76b1e2d899!2sAssistance+%E2%80%93+H%C3%B4pitaux+De+Paris!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="_blank"><i class="icon_pin_alt"></i>Directions</a></li>
								<li><a href="./detail-page.html">Book now</a></li>
							</ul>
						</div>
					</div>
					<!-- /box_list -->


				</div>
				<!-- /row -->

				<!--<nav aria-label="" class="add_top_20">
					<ul class="pagination pagination-sm">
						<li class="page-item disabled">
							<a class="page-link" href="#" tabindex="-1">Previous</a>
						</li>
						<li class="page-item active"><a class="page-link" href="#">1</a></li>
						<li class="page-item"><a class="page-link" href="#">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item">
							<a class="page-link" href="#">Next</a>
						</li>
					</ul>
				</nav>-->
				<!-- /pagination -->
			</div>
			<!-- /col -->

			<aside class="col-lg-4" id="sidebar">
				<div id="map" class="normal_list">
				</div>
			</aside>
			<!-- /aside -->

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

	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLZsnuumGUJMP07RAhSrly-wSezRXi19U&callback=initMap">
	</script>
	<!-- SPECIFIC SCRIPTS -->
	<script src="../../maps.googleapis.com/maps/api/js.js"></script>
    <script src="./js/map_listing.js"></script>
    <script src="./js/infobox.js"></script>


</body>
</html>
