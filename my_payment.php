<?php
	include_once 'config.php';
	include_once 'token.php';
	$v = notVerified();
	if($v){
		header('Location:account_issue');
	}
	$m_id = isloggedin();
?>
<html lang="en">

<head>
	<title>Payment -- Doctor Appointment System -- Findoctor</title>
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
	
		<div id="results">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h4 style="padding-bottom:5px;"><strong>Payment History</strong></h4>
					</div>
				</div>
			</div>
		</div>
		
		<div class="table-responsive" id="payment_record">
			 <table style="margin-left:92px; margin-top:30px; margin-bottom:30px;">
				  <tr>
					   <th class="tablep"><a id="payment_id" style="padding-right:40px;">Payment ID</a></th>
					   <th class="tablep"><a id="pay_date" style="padding-right:120px;">Paid Date</a></th>
					   <th class="tablep"><a id="medium" style="padding-right:40px;">Medium</a></th>
					   <th class="tablep"><a id="amount" style="padding-right:40px;">Amount</a></th>
					   <th class="tablep"><a id="Detail" style="padding-right:40px;">Detail</a></th>
				  </tr>
				  <?php
				  $sql2 = mysql_query("SELECT id,date_time, medium, info, amount FROM Payments WHERE user_id = '$m_id' ");
				  while($row2 = mysql_fetch_array($sql2,MYSQL_NUM))
				  {
				  ?>
				  <tr>
					   <td style="padding-top:15px;"><?php echo $row2[0]; ?></td>
					   <td style="padding-top:15px;"><?php echo $row2[1]; ?></td>
					   <td style="padding-top:15px;"><?php echo $row2[2]; ?></td>
					   <td style="padding-top:15px;"><?php echo $row2[4]; ?></td>
					   <td style="padding-top:15px;"><?php echo $row2[3]; ?></td>
				  </tr>
				  <?php
				  }
				  ?>
			 </table>
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
