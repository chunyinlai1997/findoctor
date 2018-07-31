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
	<title>FAQ -- Doctor Appointment System -- Findoctor</title>
	<?php include 'head-info.php';
	?>
	<style>
	#map {
  height: 600px;
  width: 100%;
	}
	</style>
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
				<h2>FAQs</h2>
				<p>Below are some popular quesions from our users. If you cannot find your
				 questions here, please contact us by email or phone. Thank you.</p>
			</div>
			<div class="row justify-content-center">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="list_home">
						<div class="list_title">
							<i class="icon_question"></i>
							<h3>What is your question?</h3>
						</div>
						<ul>
							<li><a href="#0"><strong>1</strong>Do you accept new clinics or doctors joining?</a></li>
							<li><a href="#0"><strong>2</strong>Can I find clinics or doctors outside Hong Kong in Findoctor?</a></li>
							<li><a href="#0"><strong>3</strong>Do I need to paid for your services?</a></li>
							<li><a href="#0"><strong>4</strong>Can I get back my medical records in the past?</a></li>
							<li><a href="#0"><strong>5</strong>What if I can't find the doctor or clinic I am looking for?</a></li>
							<li><a href="#0"><strong>6</strong>When should I make, change or cancel an appointment?</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /row -->
		</div>
		
		<img src="./img/faq-header.png" width="100%" align="middle">
		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Can't find your questions?</h2>
				<p>We will never leave you alone.</p>
			</div>
			<div class="row add_bottom_30">
				<div class="col-lg-6">
					<div class="box_feat" style="padding-top:30px;">
					<img src="./img/email_1.png" width="150px" height="150px" align="middle">
						<h3 style="color:#00a98f;">Send us an email</h3>
						<p><a href="../cdn-cgi/l/email-protection.html#8fe6e1e9e0cfe9e6e1ebe0ecfbe0fda1ece0e2" style="color:#000;"><i class="icon_mail_alt" style="color:#ff4f81;"></i> info@findoctor.com</a></p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box_feat" style="padding-top:30px;">
					<img src="./img/phone_1.png" width="150px" height="150px" align="middle">
						<h3 style="color:#00a98f;">Give us a call</h3>
						<p><a href="tel://28882888" style="color:#000;"><i class="icon_mobile" style="color:#ff4f81;"></i> +852 2888 2888</a></p>
					</div>
				</div>
			</div>
		</div>
	</main>
	
	
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
