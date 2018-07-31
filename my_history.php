<?php
	include_once 'config.php';
	include_once 'token.php';
	$v = notVerified();
	if($v){
		header('Location:account_issue');
	}
	$m_id = isloggedin();
	$hid=($_GET["history"]) 
?>
<html lang="en">

<head>
	<title>History -- Doctor Appointment System -- Findoctor</title>
	<?php include 'head-info.php';?>
	
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
	
	

		  <div align='center'>
		  <?php
		  $sql2 = mysql_query("SELECT id, doctor_comment, prescription, require_followup, referrals FROM Patient_Records WHERE aid = $hid   ");
		  $num_rows = mysql_num_rows($sql2);
		  if ($num_rows>0){
		  while($row2 = mysql_fetch_array($sql2,MYSQL_NUM)){
			

		 

			    echo "Doctor_comment: ".$row2[1];
				echo "Prescription: ".$row2[2]; 
				echo "Followup: ".$row2[3]; 
				echo "Referrals: ".$row2[4];
		  }
		  }
			else{
				echo "NO Record Found ";
				}
		   
		  ?>
		  </div>
	</main>
	

	
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
