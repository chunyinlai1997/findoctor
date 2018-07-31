<?php
include_once 'config.php';
include_once 'token.php';
session_start();
if(isloggedin()){
	header('Location:home.php');
}
else{
	checker();
}

function checker(){
	if(isset($_POST['submit']) && !empty($_POST['submit'])):
	    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])):
	        //your site secret key
	        $secret = '6LcN5jQUAAAAACa2GtQVN-n7lw3gLgu6RDMCoufK';
	        //get verify response data
	        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	        $responseData = json_decode($verifyResponse);
	        if($responseData->success):
	           validate();
	        else:
	            header('Location:login?re=FAIL_CAPTCHA');
	        endif;
	    else:
	        header('Location:login?re=NO_SUBMIT_CAPTCHA');
	    endif;
	else:
		header('Location:login?re=NO_SUBMIT');
	endif;
}

function validate(){
	if(isset($_POST['submit'])){
		$email= $_POST['email'];
		$pass = $_POST['password'];
		$sql= mysql_query("SELECT id, email, password, role, status, verified FROM Users WHERE email = '$email'")or die(mysql_error());
		$row= mysql_fetch_array($sql,MYSQL_NUM);
		$hp = $row[2];
		if(password_verify($pass,$hp)) {
			$cstrong = True;
			$token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
			$h_token = sha1($token);
			$user_id = $row[0];
			$role = $row[3];
			$status = $row[4];
			$verified = $row[5];
			$ipaddress = $_SERVER['REMOTE_ADDR'];
			//temp direct to index
			//header("Location:index");
			mysql_query("INSERT INTO Token(token,user_id,role,ip_address) VALUES('$h_token ','$user_id','$role','$ipaddress')");
			setcookie("SNID",$token,time()+60*60*24*1,'/',NULL,NULL,TRUE);	//first login token will expire after 24 hours
			setcookie("SNID_",'1',time()+60*60*24*0.5,'/',NULL,NULL,TRUE);	//second login token will expire after 12 hours
			if($role=="patient"){
				if($verified==0){
					header("Location:account_issue");
				}
				else{
					if($status=="inactive"){
						header("Location:account_issue");
					}
					else if($status=="blocked"){
						header("Location:account_issue");
					}
					else{
						if($_SESSION["isSearching"]==1){
							$qr = $_SESSION['bookQuery'];
							header("Location:$qr");
						}
						header("Location:index");
					}
				}
			}
			else if($role=="staff"){
				header("Location:staff_login");
			}
			else if($role=="admin"){
				header("Location:admin_login");
			}
		}
		else{
			header("Location:login?ac=WRONG");
		}
	}
	else{
		header("Location:login?ac=NO_SUBMIT");
	}
}
?>
