<?php
include_once 'config.php';
include_once 'token.php';

function get_time_options($timeslot,$apply_date,$did){
  $all = ['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'];
  $morning = ['09:00','09:30','10:00','10:30','11:00','11:30'];
  $afternoon = ['12:00','12:30','13:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30'];
  $night = ['18:00','18:30','19:00','19:30'];
  $apply_time = "";

  if($timeslot=="All"){
    $apply_time = $all;
  }
  else if($timeslot=="Morning"){
    $apply_time = $morning;
  }
  else if($timeslot=="Afternoon"){
    $apply_time = $afternoon;
  }
  else if($timeslot=="Night"){
    $apply_time = $night;
  }
  else{
    $apply_time = $all;
  }

  //$apply_date = $_GET['date'];
  $start_time = $apply_time[0];
  $end_time = end($apply_time);
  $print_time = "";
  $sql7 = mysql_query("SELECT * FROM DoctorException WHERE udate='$apply_date' AND doctor_id='$did' ");
  $numN = mysql_num_rows($sql7);
  if($numN==1){
    $print_time = "";
  }
  else{
    $sql8 = mysql_query("SELECT btime FROM Appointments A WHERE bdate='$apply_date' AND btime between '$start_time' and '$end_time' AND doctor_id='$did' AND status='booked' or status='confirmed' ");
    while($rowt = mysql_fetch_array($sql8,MYSQL_NUM)){
      foreach ($apply_time as $t) {
        if($rowt[0]==$t.':00'){
          $keyToDelete = array_search($t, $apply_time);
          unset($apply_time[$keyToDelete]);
        }
      }
    }
    foreach ($apply_time as $t) {
      $print_time .= "<option value='$t'>$t</option>";
    }
  }

  return  $print_time;
}


if(isset($_POST['get_time_options'])){
  $timeslot = $_POST['timeslot'];
  $apply_date = $_POST['apply_date'];
  $did = $_POST['did'];
  $all = ['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30'];
  $morning = ['09:00','09:30','10:00','10:30','11:00','11:30'];
  $afternoon = ['12:00','12:30','13:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30'];
  $night = ['18:00','18:30','19:00','19:30'];
  $apply_time = "";

  if($timeslot=="All"){
    $apply_time = $all;
  }
  else if($timeslot=="Morning"){
    $apply_time = $morning;
  }
  else if($timeslot=="Afternoon"){
    $apply_time = $afternoon;
  }
  else if($timeslot=="Night"){
    $apply_time = $night;
  }
  else{
    $apply_time = $all;
  }

  //$apply_date = $_GET['date'];
  $start_time = $apply_time[0];
  $end_time = end($apply_time);
  $print_time = "";
  $sql7 = mysql_query("SELECT * FROM DoctorException WHERE udate='$apply_date' AND doctor_id='$did' ");
  $numN = mysql_num_rows($sql7);
  if($numN==1){
    $print_time = "";
  }
  else{
    $sql8 = mysql_query("SELECT btime FROM Appointments A WHERE  bdate='$apply_date' AND btime between '$start_time' and '$end_time' AND doctor_id='$did' AND status='booked' or status='confirmed' ");
    while($rowt = mysql_fetch_array($sql8,MYSQL_NUM)){
      foreach ($apply_time as $t) {
        if($rowt[0]==$t.':00'){
          $keyToDelete = array_search($t, $apply_time);
          unset($apply_time[$keyToDelete]);
        }
      }
    }
    foreach ($apply_time as $t) {
      $print_time .= "<option value='$t'>$t</option>;";
    }
  }

  echo  $print_time;

}

if(isset($_POST["get_book"])){
  $date = $_POST["apply_date"];
  $time = $_POST["apply_time"];
  $did = $_POST["did"];
  $sql = mysql_query("SELECT Clinics.address, Clinics.name, Doctor.firstname, Doctor.lastname FROM Clinics, Doctor WHERE Clinics.branch_id = Doctor.clinic_id AND Doctor.id = '$did'");
  $rowt = mysql_fetch_array($sql,MYSQL_NUM);
  $add = $rowt[0];
  $name = $rowt[1];
  $fname = $rowt[2];
  $lname = $rowt[3];

  echo "
  <h2>Booking Record</h2>
  <table class='table'>
    <caption>
    Please complete the payment to confirm this appointment.
    </caption>
    <thead>
      <tr>
        <th scope='col'>Clinic Name and Address</th>
        <th scope='col'>Doctor</th>
        <th scope='col'>Date</th>
        <th scope='col'>Time</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope='row'>$name<br>$add</th>
        <td>Dr. $fname $lname</td>
        <td>$date</td>
        <td>$time</td>
      </tr>
    </tbody>
  </table>


  <fieldset class='col-md-12'>
  		<div class='form-top'>
  			<div class='form-top-left'>
  				<h3>Credit card payment</h3>
  				<small style='font-size:80%;'>Please complete the payment now.</small>
  			</div>
  		</div>
  		<div class='form-bottom'>
  		  <div class='card card-block' id='payform' style='display:block;margin-buttom:20px;'>
  			<!-- form card cc payment -->
  			<div class='card card-outline-secondary' style='padding:10px;'>
  				<div class='card-block'>
  					<div class='form-group text-center'>
  						<ul class='list-inline'>
  							<li class='list-inline-item'><i class='text-muted fa fa-cc-visa fa-2x'></i></li>
  							<li class='list-inline-item'><i class='fa fa-cc-mastercard fa-2x'></i></li>
  							<li class='list-inline-item'><i class='fa fa-cc-amex fa-2x'></i></li>
  							<li class='list-inline-item'><i class='fa fa-cc-discover fa-2x'></i></li>
  						</ul>
  					</div>
  					<hr>
  						<div class='form-group'>
  						<label class='col-md-12'>Payment Detail</label>
  						<input type='text' class='form-control' readonly value='Online Booking Service (Fully refund to consultantion fee)'>
  						</div>
  						<div class='form-group'>
  							<label for='cc_name'>Card Holder's Name</label>
  							<input type='text' class='form-control' id='cc_name' onkeyup='check_hname(this);'  name='cc_name' title='First and last name' >
  						</div>
  						<div id='vcname' class='invalid-feedback' style='display:none;'></div>
  						<div class='form-group'>
  							<label>Card Number</label>
  							<div class='input-group'>
  								<div class='input-group-addon' id='cardtype' style='dsiplay:none;'></div>
  								<input type='text' class='form-control' name='cardnum' autocomplete='off' maxlength='20' id='cardnum' onkeyup='CardNumber();' onchange='CardNumber();' title='Credit card number' >
  							</div>
  						</div>
  						<div id='vcnum' class='invalid-feedback' style='display:none;'></div>
  						<div class='form-group row'>
  							<label class='col-sm-10'>Card Exp. Date</label>
  							<div class='col-md-4'>
  								<select id='exMonth' name='cc_exp_mo' class='form-control' onchange='check_exp();' onkeyup='check_exp();' size='0'>
  									<option value='1'>01</option>
  									<option value='2'>02</option>
  									<option value='3'>03</option>
  									<option value='4'>04</option>
  									<option value='5'>05</option>
  									<option value='6'>06</option>
  									<option value='7'>07</option>
  									<option value='8'>08</option>
  									<option value='9'>09</option>
  									<option value='10'>10</option>
  									<option value='11'>11</option>
  									<option value='12'>12</option>
  								</select>
  							</div>
  							<div class='col-md-4'>
  								<select id='exYear' name='cc_exp_yr'  class='form-control' onchange='check_exp();' onkeyup='check_exp();'  size='0'>
  									<option value='2017'>2017</option>
  									<option value='2018'>2018</option>
  									<option value='2019'>2019</option>
  									<option value='2020'>2020</option>
  									<option value='2021'>2021</option>
  									<option value='2022'>2022</option>
  									<option value='2023'>2023</option>
  									<option value='2024'>2024</option>
  									<option value='2025'>2025</option>
  									<option value='2026'>2026</option>
  									<option value='2027'>2027</option>
  								</select>
  							</div>
  							<div class='col-md-4'>
  								<input type='text' class='form-control' autocomplete='off' maxlength='3' onkeyup='check_cvc(this);' id='cvc' pattern='\d{3}' title='Three digits at back of your card' placeholder='CVC'>
  							</div>
  						</div>
  						<div id='vdate' class='invalid-feedback' style='display:none;'></div>
  						<div id='vcvc' class='invalid-feedback' style='display:none;'></div>

  						<div class='row'>
  							<label class='col-md-12'>Amount</label>
  						</div>
  						<div class='form-inline'>
  							<div class='input-group'>
  								<div class='input-group-addon'>$</div>
  								<input type='text' class='form-control text-right' value='50' name='amount' readonly>
  								<div class='input-group-addon'>HKD</div>
  							</div>
  						</div>
  					</div>
  					<hr>
  					<div style='height:30px;'/>
  				</div>
  			</div>
  			<!-- /form card cc payment -->
  		</div>
  	</fieldset>
    <br>
    <div class='row justify-content-center'>
      <div class='col-12 text-center'>
        <button type='submit' disabled class='btn_1 medium' value='Book' name='Book' id='Book_btn' >Book Now</button>
      </div>
    </div>
  ";
}
?>
