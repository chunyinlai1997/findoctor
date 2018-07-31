<?php

include_once 'config.php';
include_once 'token.php';

if(isset($_GET['logout']) && $_GET['logout']==$_COOKIE['SNID_']){
		if(isset($_COOKIE['SNID'])){
			$t  = sha1($_COOKIE['SNID']);
			mysql_query("DELETE FROM Token  WHERE token= '$t'")or die(mysql_error());
		}
		unset($_COOKIE['SNID']);
		unset($_COOKIE['SNID_']);
		setcookie('SNID', null, -1, '/');
		setcookie('SNID_', null, -1, '/');
}
header("Location:index");

?>
