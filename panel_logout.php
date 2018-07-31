<?php

include_once 'config.php';
include_once 'token.php';
if(!isloggedin()){
  header("Location:index");
}
$role = getRole();
$link = 'index';
if(!isAuth()){
  header("Location:index");
}
else{
  if($role=='admin'){
    $link = 'admin_login';
  }
  else if($role=='staff'){
    $link = 'staff_login';
  }
}

if(isset($_GET['logout']) && $_GET['logout']==$_COOKIE['SNID2_']){
		if(isset($_COOKIE['SNID2'])){
			$t  = sha1($_COOKIE['SNID2']);
			mysql_query("DELETE FROM Token2  WHERE token= '$t'")or die(mysql_error());
		}
		unset($_COOKIE['SNID2']);
		unset($_COOKIE['SNID2_']);
		setcookie('SNID2', null, -1, '/');
		setcookie('SNID2_', null, -1, '/');
}
header("Location:$link");

?>
