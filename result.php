<?php
	include_once 'config.php';
	include_once 'token.php';
	include 'header.php';
	$v = notVerified();
	if($v){
		header('Location:account_issue');
	}
	session_start();
	$bdate = $_SESSION['date'];
	$btime = $_SESSION['timeslot'];
	$bdis = $_SESSION['district'];
	$bspec = $_SESSION['specialization'];

	$addition = "";
	$has1 = false;
	$has2 = false;
	$has3 = false;
	$has4 = false;

	if($bdis!=""){
		$has3 = true;
		$addition .= " AND Clinics.district = '$bdis' ";
	}
	if($bspec!=""){
		$has4 = true;
		$addition .= " AND Doctor.specialization = '$bspec' ";
	}
	if($bdate!=""){
		$has1 = true;
		$addition .= " AND Doctor.id NOT IN (SELECT doctor_id FROM DoctorException WHERE udate = '".$bdate."' GROUP BY doctor_id HAVING COUNT(id)=1)";
		if($btime!=""){
			$has2 = true;
			$number = 0;
			if($btime=="Morning"){
				$addition .= " AND Doctor.id NOT IN (SELECT doctor_id FROM Appointments A WHERE btime between '09:00' and '11:59' GROUP BY doctor_id HAVING COUNT(aid)>=6)";
			}
			else if($btime=="Afternoon"){
				$addition .= " AND Doctor.id NOT IN (SELECT doctor_id FROM Appointments A WHERE btime between '12:00' and '17:59' GROUP BY doctor_id HAVING COUNT(aid)>=13)";
			}
			else if($btime=="Night"){
				$addition .= " AND Doctor.id NOT IN (SELECT doctor_id FROM Appointments A WHERE btime between '18:00' and '19:59' GROUP BY doctor_id HAVING COUNT(aid)>=4)";
			}
			else if($btime=="All"){
				$addition .= " AND Doctor.id NOT IN (SELECT doctor_id FROM Appointments A WHERE btime between '09:00' and '19:59' GROUP BY doctor_id HAVING COUNT(aid)>=23)";
			}
		}
	}

	$q = "SELECT Doctor.lastname,Doctor.specialization,Clinics.Name,Doctor.education,Doctor.qualification,Clinics.address,Doctor.id,Doctor.photo_img,Doctor.gender,Doctor.about FROM Doctor, Clinics WHERE Clinics.branch_id = Doctor.clinic_id ".$addition;
	$sqldoctor = mysql_query($q);

	$result_doctor = generate_doctor($sqldoctor);
	$printd = $result_doctor[1];
	$found = $result_doctor[0];

	function generate_doctor($sqldoctor){
		$bdate = $_SESSION['date'];
		$btime = $_SESSION['timeslot'];
		$result_doctor = "";
		$num = 0;
		while($rowd = mysql_fetch_array($sqldoctor,MYSQL_NUM)){
			$num +=1;
			$dlast = $rowd[0];
			$dspec = $rowd[1];
			$cname = $rowd[2];
			$dedu = $rowd[3];
			$dqua = $rowd[4];
			$cadd = $rowd[5];
			$did = $rowd[6];
			$photo = $rowd[7];
			$gender = $rowd[8];
			$about = $rowd[9];

			$result_doctor .= "

			<div class='col-md-4'>
				<div class='box_list wow fadeIn'>
					<a href='#0' class='wish_bt'></a>
					<figure>
						<a href='book?did=$did&date=&timeslot='><img src='img/$photo' class='img-fluid' alt='' />
							<div class='preview'><span>Read more</span></div>
						</a>
					</figure>
					<div class='wrapper'>
						<small>$dspec</small>
						<h3>Dr. $dlast</h3>
						<p>$about</p>
						<h6>Education: $dedu</h6>
						<h6>Qualification: $dqua</h6>
						<h6>Gender: $gender</h6>
						<hr>
						<h6><a href='clinic?$cname'>$cname</a></h6>
					</div>
					<ul>
						<li><a href='#0' onclick='onHtmlClick('Doctors', 0)'><i class='icon_pin_alt'></i>View on map</a></li>
						<li><a href='https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x0:0xa6a9af76b1e2d899!2sAssistance+%E2%80%93+H%C3%B4pitaux+De+Paris!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361' target='_blank'><i class='icon_pin_alt'></i>Directions</a></li>
						<li><a href='book?did=$did&date=$bdate&timeslot=$btime'>Book now</a></li>
					</ul>
				</div>
			</div>
			";
		}
		return array($num,$result_doctor);
	}

	function isD($d){
    if($d==$_SESSION["district"]){
      return "selected";
    }
    else{
      return " ";
    }
  }

  function isS($s){
    if($s==$_SESSION["specialization"]){
      return "selected";
    }
    else{
      return " ";
    }
  }

	function isT($t){
    if($t==$_SESSION["timeslot"]){
      return "selected";
    }
    else{
      return " ";
    }
  }


?>
<html lang="en">

<head>
	<title>Result -- Doctor Appointment System -- Findoctor</title>
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
		 <form action="action_search" method="post">
			 <div class="row">
				 <div class="col-lg-3 col-md-6 col-6">
					 <div class="input-group">
						 <label for='district' class='col-12 col-form-label'>District</label>
						 <select class='form-control' name='district' id='district'>
							 <option <?php echo isD("All");?> value="All">All District</option>
							 <option disabled='true'>--Hong Kong Island--</option>
							 <option disabled='true'></option>
							 <option <?php echo isD("Eastern District");?> value='Eastern District'>Eastern District 東區 </option>
							 <option disabled='true'></option>
							 <option disabled='true'>--Kowloon--</option>
							 <option disabled='true'></option>
							 <option <?php echo isD("Kowloon City District");?> value='Kowloon City District'>Kowloon City District 九龍城 </option>
							 <option <?php echo isD("Kwun Tong District");?> value='Kwun Tong District'>Kwun Tong District 觀塘 </option>
							 <option <?php echo isD("Sham Shui Po District");?> value='Sham Shui Po District'>Sham Shui Po District 深水埗  </option>
							 <option <?php echo isD("Wong Tai Sin District");?> value='Wong Tai Sin District'> Wong Tai Sin District 黃大仙 </option>
							 <option <?php echo isD("Yau Tsim Mong District");?> value='Yau Tsim Mong District'>Yau Tsim Mong District 油尖旺  </option>
							 <option disabled='true'></option>
							 <option disabled='true'>--New Territories--</option>
							 <option disabled='true'></option>
							 <option <?php echo isD("Islands District");?> value='Islands District'> Islands District 離島 </option>
							 <option <?php echo isD("Kwai Tsing District");?> value='Kwai Tsing District'> Kwai Tsing District 葵青 </option>
							 <option <?php echo isD("North District");?> value='North District'>North District 北區  </option>
							 <option <?php echo isD("Sai Kung District");?> value='Sai Kung District'>Sai Kung District 西貢 </option>
							 <option <?php echo isD("Tai Po District");?> value='Tai Po District'>Tai Po District 大埔 </option>
							 <option <?php echo isD("Tsuen Wan District");?> value='Tsuen Wan District'>Tsuen Wan District 荃灣 </option>
							 <option <?php echo isD("Tuen Mun District");?> value='Tuen Mun District'>Tuen Mun District 屯門 </option>
							 <option <?php echo isD("Yuen Long District");?> value='Yuen Long District'>Yuen Long District 元朗</option>
						 </select>

					 </div>
				 </div>
				 <div class="col-lg-3 col-md-6 col-6">
					 <div class="input-group">
						 <label for='specialization' class='col-12 col-form-label'>Specialization</label>
						 <select class='form-control' name='specialization' id='specialization'>
							 <option <?php echo isS("All");?>  value="All">All Specialization</option>
							 <option <?php echo isS("Primary Care");?> value='Primary Care'>Primary Care</option>
							 <option <?php echo isS("Cardiology");?> value='Cardiology'>Cardiology</option>
							 <option <?php echo isS("MRI Resonance");?> value='MRI Resonance'>MRI Resonance</option>
							 <option <?php echo isS("Blood test");?> value='Blood test'>Blood test</option>
							 <option <?php echo isS("Laboratory");?> value='Laboratory'>Laboratory</option>
							 <option <?php echo isS("Dentistry");?> value='Dentistry'>Dentistry</option>
							 <option <?php echo isS("X - Ray");?> value='X - Ray'>X - Ray</option>
							 <option <?php echo isS("Piscologist");?> value='Piscologist'>Piscologist</option>
						 </select>

					 </div>
				 </div>
				 <div class="col-lg-3 col-md-6 col-6">
					 <div class="input-group">
						 <label for='date' class='col-12 col-form-label'>Pick a day</label>
						 <input class='form-control' value="<?php echo $_SESSION["date"]; ?>" id="date" name="date" type="date">
					 </div>
				 </div>
				 <div class="col-lg-3 col-md-6 col-6">
					 <div class="input-group">
						 <label for='timeslot' class='col-12 col-form-label'>Timeslot</label>
						 <select class='form-control' name='timeslot' id='timeslot'>
							 <option <?php echo isT("All");?>  value="All">All Timeslot</option>
							 <option <?php echo isT("Morning");?>  value='Morning'>Morning</option>
							 <option <?php echo isT("Afternoon");?>  value='Afternoon'>Afternoon</option>
							 <option <?php echo isT("Night");?>  value='Night'>Night</option>
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
					<h3><?php echo $found; ?> Results</h3>
				</li>
				<li>
					<h6>Layout</h6>
					<div class="layout_view">
						<a href="#0" class="active"><i class="icon-th"></i></a>
						<a href="#0"><i class="icon-th-list"></i></a>
						<a href="#0"><i class="icon-map-1"></i></a>
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
			<div class="col-lg-12">
				<div class="row">


					<!-- /box_list -->

					<?php echo $printd; ?>


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

			<!--<aside class="col-lg-4" id="sidebar">
				<div id="map" class="normal_list">
				</div>
			</aside>-->
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
</body>
</html>
