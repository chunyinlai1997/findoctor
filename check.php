<?php

include_once 'config.php';
include_once 'token.php';

if(isset($_POST["checkemail"])){
	$email = $_POST["checkemail"];
	$sql2= mysql_query("SELECT * FROM Users WHERE email ='$email'")or die(mysql_error());
	echo mysql_num_rows($sql2);
}

if(isset($_POST["simplecheckemail"])){
	$email = $_POST["simplecheckemail"];
	$id = isloggedin();
	$sql2= mysql_query("SELECT * FROM Users WHERE email ='$email' and id!='$id'")or die(mysql_error());
	echo mysql_num_rows($sql2);
}

if(isset($_POST["checkPass"])){
	$pass = $_POST["checkPass"];
	$id = isloggedin();
	$sql2= mysql_query("SELECT password FROM Users WHERE id ='$id'")or die(mysql_error());
	$result = mysql_fetch_array($sql2,MYSQL_NUM);
	$real = $result[0];
	if(password_verify($pass,$real)) {
		echo true;
	}
	else{
		echo false;
	}
}









?>
