<?php
include_once 'config.php';
include_once 'token.php';
$isLoggedin = getLoginStatus();
if(!$isLoggedin){
  header("Location:login");
}
else{
  $role = getRole();
  if($role=="patient"){
    header("Location:index");
  }
  else if($role=="admin"){
    header("Location:admin_login");
  }
  else{
    checker();
  }
}

function checker(){
	validate();
}

function validate(){
  if(isset($_POST['submit'])){
    $staffcode = $_POST['staffcode'];
    $user_id = isloggedin();
    $sql= mysql_query("SELECT staff_code FROM Staff WHERE user_id = '$user_id'")or die(mysql_error());
		$row= mysql_fetch_array($sql,MYSQL_NUM);
		$hp = $row[0];
    if(password_verify($staffcode,$hp)){
      $cstrong = True;
			$token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
			$h_token = sha1($token);
      mysql_query("INSERT INTO Token2(token,user_id) VALUES('$h_token ','$user_id')");
			setcookie("SNID2",$token,time()+60*60*24*1,'/',NULL,NULL,TRUE);	//first login token will expire after 24 hours
			setcookie("SNID2_",'1',time()+60*60*24*1,'/',NULL,NULL,TRUE);	//second login token will expire after another 24 hours
      header('Location:staff/index');
    }
    else{
      header("Location:staff_login?ac=WRONG");
    }
  }
  else{
    header("Location:staff_login?ac=NO_SUBMIT");
  }
}
?>
