<?php
  include_once 'config.php';
  include_once 'token.php';
  $id = isLoggedin();
  session_start();
  $did = "";
  $bdate = "";
  $btime = "";

  $v = notVerified();
  if($v){
  	header('Location:account_issue');
  }
  $r = getRole();
  if($r!="patient"){
    header("Location:staff_login");
  }

  if(isset($_GET["did"])&&!empty($_GET["did"])){
    $did = $_GET["did"];
    $bdate = $_GET["date"];
    $btime = $_GET["timeslot"];

    if(empty($_SESSION["isSearching"])){
      if(!$id){
        $_SESSION["isSearching"] = 1;
        $_SESSION['bookQuery'] = "book?did=$did&date=$bdate&timeslot=$btime";
        header("Location:login");
      }
    }
    else{
      if(!$id){
        header("Location:login");
      }
      if($_SESSION["isSearching"] == 1){
        $_SESSION["isSearching"] = 0;
        $_SESSION['bookQuery'] = "";
      }
    }
  }
  else{
    header("Location:result");
  }

?>

<html lang="en">

<head>
	<title> Book --Doctor Appointment System --  ABC Medical Company</title>
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
					<li><a href="result">Search Result</a></li>
					<li>Make Appointment</li>
				</ul>
			</div>
		</div>
		<!-- /breadcrumb -->
    <?php
    $q = mysql_query("SELECT Doctor.lastname,Doctor.specialization,Clinics.Name,Doctor.education,Doctor.qualification,Clinics.address,Doctor.id,Doctor.photo_img,Doctor.gender,Doctor.about,Doctor.firstname FROM Doctor, Clinics WHERE Clinics.branch_id = Doctor.clinic_id AND Doctor.id = ".$did." ");
    $row = mysql_fetch_array($q,MYSQL_NUM);
    $dlast = $row[0];
    $dspec = $row[1];
    $cname = $row[2];
    $dedu = $row[3];
    $dqua = $row[4];
    $cadd = $row[5];
    $did = $row[6];
    $photo = $row[7];
    $gender = $row[8];
    $about = $row[9];
    $dfirst = $row[10];
    //default
    include 'generate_time.php';

    $apply_time = "";
    if(isset($_GET['timeslot'])&&!empty($_GET['timeslot'])){
      if($_GET['timeslot']=="All"){
        $apply_time = "All";
      }
      else if($_GET['timeslot']=="Morning"){
        $apply_time = "Morning";
      }
      else if($_GET['timeslot']=="Afternoon"){
        $apply_time = "Afternoon";
      }
      else if($_GET['timeslot']=="Night"){
        $apply_time = "Night";
      }
    }
    else{
      $apply_time = "All";
    }
    $apply_date = $_GET['date'];

    $print_time = get_time_options($apply_time,$apply_date,$did);

    ?>
		<div class="container margin_60">
			<div class="row">
				<aside class="col-xl-3 col-lg-4" id="sidebar">
					<div class="box_profile">
						<figure>
							<img src="./img/<?php echo $photo; ?>" alt="" class="img-fluid" />
						</figure>
						<small><?php echo $dspec; ?></small>
						<h1>DR. <?php echo $dfirst." ".$dlast; ?></h1>
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
							<li><?php echo $gender; ?></li>
							<li>124 Patients</li>
						</ul>
						<ul class="contacts">
              <li><h6>Clinic</h6><?php echo "<a href='clinic?".$cname."'>".$cname."</a>"; ?></li>
							<li><h6>Address</h6><?php echo $cadd; ?></li>
						</ul>
						<div class="text-center"><a href="https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x0:0xa6a9af76b1e2d899!2sAssistance+%E2%80%93+H%C3%B4pitaux+De+Paris!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" class="btn_1 outline" target="_blank"><i class="icon_pin"></i> View on map</a></div>
					</div>
				</aside>
				<!-- /asdide -->

				<div class="col-xl-9 col-lg-8">
					<div class="tabs_styled_2">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="book-tab" data-toggle="tab" href="#book" role="tab" aria-controls="book">Book an appointment</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-expanded="true">General info</a>
							</li>
						</ul>
						<!--/nav-tabs -->
            <?php
            function isT($t){
              if(isset($_GET['timeslot'])&&!empty($_GET['timeslot'])){
                if($_GET['timeslot']==$t){
                  return "selected";
                }
              }
              else{
                return " ";
              }
            }

            ?>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="book" role="tabpanel" aria-labelledby="book-tab">
								<p class="lead add_bottom_30">Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
								<form action="action_booking" method="POST">
									<div class="main_title_3">
										<h3><strong>1</strong>Select your date</h3>
									</div>
									<div class="form-group add_bottom_45">
										<div class="row" style="margin-bottom:10px;">
                      <div class=" col-6">
             					 <div class="input-group">
             						 <label for='date' class='col-12 col-form-label'>Pick a day</label>
             						 <input class='form-control' value="<?php echo $bdate; ?>" id="date" name="date" type="date">
             					 </div>
             				 </div>
             				 <div class="col-6">
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
                     <input class='form-control' value="<?php echo $did; ?>" id="print_did" hidden name="did" type="text">
                    </div>
									</div>
									<div class="main_title_3">
										<h3><strong>2</strong>Select your time</h3>
									</div>
									<div class="row justify-content-center add_bottom_45">
										<div class="col-12 text-center">
                      <select class='form-control' name='timeoption' id='timeoption'>
                        <? echo $print_time; ?>
                      </select>
										</div>
                    <br>
                    <br>
                    <br>
                    <a href="#getLastPart" id="continue" role="button" class="btn_1 medium">Continue</a>
									</div>
									<!-- /row -->
									<div class="main_title_3" id="getLastPart">
										<h3><strong>3</strong>Confirm and Payment</h3>
									</div>
                  <div class="row justify-content-center add_bottom_45">
										<div class="col-12 text-center">
                      <div id="confirmtable">
                      </div>
										</div>
									</div>
								</form>
							</div>
							<!-- /tab_1 -->
							<div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                <!--<p class="lead add_bottom_30">Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
								-->
                <div class="indent_title_in">
									<i class="pe-7s-user"></i>
									<h3>Professional statement</h3>
									<!--<p>Mussum ipsum cacilds, vidis litro abertis.</p>-->
								</div>
								<div class="wrapper_indent">
									<p><?php echo $about; ?></p>
									<h6>Specializations</h6>
									<div class="row">
										<div class="col-lg-12">
											<ul class="bullets">
												<li><?php echo $dspec; ?></li>
											</ul>
										</div>
									</div>
									<!-- /row-->
								</div>
								<!-- /wrapper indent -->
								<hr />
								<div class="indent_title_in">
									<i class="pe-7s-news-paper"></i>
									<h3>Education</h3>
									<!--<p>Mussum ipsum cacilds, vidis litro abertis.</p>-->
                  <div class="row">
										<div class="col-lg-12">
											<ul class="bullets">
												<li><?php echo $dedu; ?></li>
											</ul>
										</div>
									</div>
                  <h3>Qualification</h3>
                  <div class="row">
										<div class="col-lg-12">
											<ul class="bullets">
												<li><?php echo $dqua; ?></li>
											</ul>
										</div>
									</div>
								</div>
								<!--  End wrapper indent -->
								<hr />
								<div class="indent_title_in">
									<i class="pe-7s-cash"></i>
									<h3>Prices &amp; Payments</h3>
									<p>Mussum ipsum cacilds, vidis litro abertis.</p>
								</div>
								<div class="wrapper_indent">
									<table class="table table-responsive table-striped">
										<thead>
											<tr>
												<th>Service - Visit</th>
												<th>Price</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Online Booking</td>
												<td>$50 (refundable)</td>
											</tr>
											<tr>
												<td>Consultation fee</td>
												<td>$350</td>
											</tr>
											<tr>
												<td>Medicine</td>
												<td>free for 3 days</td>
											</tr>
											<tr>
												<td>Additional Treatment</td>
												<td>[depends on situation]</td>
											</tr>
										</tbody>
									</table>
								</div>
								<!--  End wrapper_indent -->

							</div>
							<!-- /tab_2 -->
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

	<!-- SPECIFIC SCRIPTS -->
    <script src="./js/bootstrap-datepicker.js"></script>
    <script>
    $(document).ready(function(){
      $("#date").change(function(){
        var date = $(this).val();
        var timeslots = $('#timeslot option:selected').text();
        var doc = $("#print_did").val();
        $.ajax({
  				url:"generate_time.php",
  				method:"POST",
  				data:{get_time_options:"",timeslot:timeslots,apply_date:date,did:doc},
  				success:function(data2){
  					$('#timeoption').html(data2);
  				}
  			});
      });

      $("#timeslot").change(function(){
        var date = $('#date').val();
        var timeslots = $('#timeslot option:selected').text();
        var doc = $("#print_did").val();
        $.ajax({
  				url:"generate_time.php",
  				method:"POST",
  				data:{get_time_options:"",timeslot:timeslots,apply_date:date,did:doc},
  				success:function(data2){
  					$('#timeoption').html(data2);
  				}
  			});
      });

      $("#timeoption").change(function(){
        var date = $('#date').val();
        var time = $('#timeoption option:selected').text();
        var doc = $("#print_did").val();
        if(date!=""){
          $.ajax({
            url:"generate_time.php",
            method:"POST",
            data:{get_book:"",apply_time:time,apply_date:date,did:doc},
            success:function(data2){
              $('#confirmtable').html(data2);
            }
          });
        }
        else{
          alert("Please pick a date");
        }
      });

      $("#continue").click(function(){
        var date = $('#date').val();
        var time = $('#timeoption option:selected').text();
        var doc = $("#print_did").val();
        if(date!=""){
        $.ajax({
  				url:"generate_time.php",
  				method:"POST",
          data:{get_book:"",apply_time:time,apply_date:date,did:doc},
          success:function(data2){
            $('#confirmtable').html(data2);
          }
        });
      }
      else{
        alert("Please pick a date");
      }
    });
  });

</script>
<script>

var visaPattern = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
var mastPattern = /^(?:5[1-5][0-9]{14})$/;
var amexPattern = /^(?:3[47][0-9]{13})$/;
var discPattern = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;

function CardNumber() {
  var ccNum  = document.getElementById("cardnum").value;
  var isVisa = visaPattern.test( ccNum ) === true;
  var isMast = mastPattern.test( ccNum ) === true;
  var isAmex = amexPattern.test( ccNum ) === true;
  var isDisc = discPattern.test( ccNum ) === true;

  if( ccNum.length >=15 && (isVisa || isMast || isAmex || isDisc) ) {
    document.getElementById("cardtype").style.display = "block";
    document.getElementById("vcnum").style.display = "none";
    document.getElementById("cardnum").classList.add('is-valid');
    document.getElementById("cardnum").classList.remove('is-invalid');
    if( isVisa ) {
      document.getElementById("cardtype").innerHTML = "<i class='fa fa-cc-visa fa-2x'>";
    }
    else if( isMast ) {
       document.getElementById("cardtype").innerHTML = "<i class='fa fa-cc-mastercard fa-2x'>";
    }
    else if( isAmex ) {
      document.getElementById("cardtype").innerHTML = "<i class='fa fa-cc-amex fa-2x'>";
    }
    else if( isDisc ) {
      document.getElementById("cardtype").innerHTML = "<i class='fa fa-cc-discover fa-2x'>";
    }
  }
  reg_sub();
}

function check_exp(){
  var e1 = document.getElementById("exMonth");
  var e2 = document.getElementById("exYear");
  var exM = e1.options[e1.selectedIndex].value;
  var exY = e2.options[e2.selectedIndex].value;
  var today = new Date();
  var someday = new Date();
  var d = new Date();
  var now_month = d.getMonth();
  var now_Year = d.getFullYear();
  document.getElementById("vdate").style.display = "block";
  if ((now_Year>exY)||(now_Year==exY && now_month+1 > exM)) {
    document.getElementById("exMonth").classList.add('is-invalid');
    document.getElementById("exMonth").classList.remove('is-valid');
    document.getElementById("exYear").classList.add('is-invalid');
    document.getElementById("exYear").classList.remove('is-valid');
    document.getElementById("vdate").innerHTML = "Please select a valid expiry date";
    document.getElementById("vdate").style.display = "block";
  }
  else{
    document.getElementById("exMonth").classList.add('is-valid');
    document.getElementById("exMonth").classList.remove('is-invalid');
    document.getElementById("exYear").classList.add('is-valid');
    document.getElementById("exYear").classList.remove('is-invalid');
    document.getElementById("vdate").style.display = "none";
  }
  reg_sub();
}

function check_hname(name){
  var hname = name.value;
  if(hname.length<6){
    document.getElementById("cc_name").classList.add('is-invalid');
    document.getElementById("cc_name").classList.remove('is-valid');
    document.getElementById("vcname").innerHTML = "Please input a valid name.";
    document.getElementById("vcname").style.display = "block";
  }
  else{
    document.getElementById("cc_name").classList.add('is-valid');
    document.getElementById("cc_name").classList.remove('is-invalid');
    document.getElementById("vcname").style.display = "none";
  }
  reg_sub();
}

function check_cvc(code){
  var cvc = code.value;
  if(cvc.length<3){
    document.getElementById("cvc").classList.add('is-invalid');
    document.getElementById("cvc").classList.remove('is-valid');
    document.getElementById("vcvc").innerHTML = "Please input a valid security code.";
    document.getElementById("vcvc").style.display = "block";
  }
  else{
    document.getElementById("cvc").classList.add('is-valid');
    document.getElementById("cvc").classList.remove('is-invalid');
    document.getElementById("vcvc").style.display = "none";
  }
  reg_sub();
}

function reg_sub(){
  var cvc_check =  document.getElementById("cvc").classList.contains('is-valid');
  var hname_check =  document.getElementById("cc_name").classList.contains('is-valid');
  var cardnum_check =  document.getElementById("cardnum").classList.contains('is-valid');
  var check_month =  document.getElementById("exMonth").classList.contains('is-valid');
  var check_year =  document.getElementById("exYear").classList.contains('is-valid');
  if(cvc_check == true && hname_check==true && cardnum_check==true && check_month == true && check_year == true ){
    document.getElementById("Book_btn").disabled = false;
  }
  else{
    document.getElementById("Book_btn").disabled = true;
  }
}

</script>

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
