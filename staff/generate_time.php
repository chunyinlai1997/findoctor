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
    $sql8 = mysql_query("SELECT btime FROM Appointments A WHERE btime between '$start_time' and '$end_time' AND doctor_id='$did' AND status='booked' or status='confirmed' ");
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
    $sql8 = mysql_query("SELECT btime FROM Appointments A WHERE btime between '$start_time' and '$end_time' AND doctor_id='$did' AND status='booked' or status='confirmed' ");
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
?>
