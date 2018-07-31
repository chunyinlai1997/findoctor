<?php
  include 'config.php';
  include 'token.php';

  if(isset($_POST["Book"])){
    $isLoggedin = isLoggedin();
    if($isLoggedin){
      $bdate = $_POST["date"];
      $did = $_POST["did"];
      $btime = $_POST["timeoption"];
      $date_time = date("Y-m-d H:i:s");
      $medium = "Credit Card";
      $info = "Online Booking Fee";
      $amount = "50";
      $id = $isLoggedin;
      $sql1 = mysql_query("SELECT specialization,clinic_id FROM Doctor WHERE id= '$did'");
      $row1 = mysql_fetch_array($sql1,MYSQL_NUM);
      $treatment = $row1[0];
      $clinic_id = $row1[1];
      mysql_query("INSERT INTO Payments(user_id,date_time,medium,info,amount) VALUES('$id','$date_time','$medium','$info','$amount')");
      $sql2 = mysql_query("SELECT id FROM Payments WHERE user_id= '$id' AND date_time = '$date_time' ");
      $row2 = mysql_fetch_array($sql2,MYSQL_NUM);
      $pid = $row2[0];
      mysql_query("INSERT INTO Appointments (doctor_id,patient_id,bdate,btime,clinic_id,treatment,payment_id) VALUES('$did','$id','$bdate','$btime','$clinic_id','$treatment','$pid')");

      $sql3 = mysql_query("SELECT email,firstname,lastname FROM Users WHERE id= '$id'");
      $row3 = mysql_fetch_array($sql3,MYSQL_NUM);
      $email = $row3[0];
      $firstname = $row3[1];
      $lastname = $row3[2];

      $sql4 = mysql_query("SELECT name,address FROM Clinics WHERE branch_id= '$clinic_id'");
      $row4 = mysql_fetch_array($sql4,MYSQL_NUM);
      $cname = $row4[0];
      $cadd = $row4[1];
      $cardnum = $_POST["cardnum"];
      $smcc= substr("$cardnum", -4);
      send_email($email,$firstname,$lastname,$cname,$cadd,$treatment,$date_time,$smcc,$bdate,$btime);
    }
    else{
      header("Location:index");
    }
  }

  function send_email($email,$firstname,$lastname,$cname,$cadd,$treatment,$date_time,$smcc,$bdate,$btime){
  	$to      = $email; // Send email to our user
  	$subject = 'Confirm Medical Appointment in '.$cname.' on '.$bdate.' '.$btime.' | Find Doctor'; // Give the email a subject
  	$message = "
  	Dear $firstname $lastname,

  	You have made an appointment on $date_time.

    Appointment Detail
  	---------------------------------------------------
    Clinic: $cname
    Location: $cadd
    Treatment: $treatment
    Date: $bdate
    Time: $btime
    Payment Method: Credit Card
    Credit Card: ****$smcc (last 4 digit)
    ----------------------------------------------------
    Please contact us for any inquries about the appoinemnt.
    Tel: +852 2888 2888 , email:  info@findoctor.com.

  	You may check and mange your booking here:
  	http://www2.comp.polyu.edu.hk/~15073415d/comp3421/findoctor/

  	Thanks,

  	Find Doctor Team
  	";

  	$headers = 'From:noreply@findoctor.team' . "\r\n";
  	mail($to, $subject, $message, $headers);
  }

?>
<html lang="en">
<head>
	<title>Booking Successful -- Doctor Appointment System --  ABC Medical Company</title>
	<?php include 'head-info.php';?>
	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>
<body>
	<div id="headprint">
		<?php
				include_once 'header.php';
				gen_header();
		?>
	</div>

	<div class="layer"></div>
	<!--css-preload-->
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>
	<main>
		<div class="bg_color_2">
			<div class="container margin_60_35">
				<div>
          <div class="row justify-content-center">
						<div class="col-sm-11 col-md-8 col-6">
			         <font style="color:white; font-size:2em;">Thank you for choosing Findoctor medical service.
               A confirmation email has sent to your email, you can view and manage your booking in "Profile-> My Booking Record".</font>
               <br>
               <hr>
               <a href="index"><button class="btn_1 medium">Back To Home</button></a>
               <a href="my_booking"><button class="btn_1 medium">View My Booking</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
	<!-- /main -->

	<?php include 'footer.php';?>

	<div id="toTop"></div>
	<!-- Back to top button -->

	<!-- COMMON SCRIPTS -->
	<script src="./js/jquery-2.2.4.min.js"></script>
	<script src="./js/common_scripts.min.js"></script>
	<script src="./js/functions.js"></script>
	<script src="./js/header.js"></script>

</body>
</html>
