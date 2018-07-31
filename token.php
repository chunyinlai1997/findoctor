<?php
	include_once 'config.php';
	function isloggedin(){
		if(isset($_COOKIE['SNID'])){
			$d_token = sha1($_COOKIE['SNID']);
			if(mysql_query("SELECT user_id FROM Token WHERE token = '$d_token'")){
				$sql = mysql_query("SELECT user_id FROM Token WHERE token = '$d_token'");
				$result = mysql_fetch_array($sql,MYSQL_NUM);
				$user_id = $result[0];
				if(isset($_COOKIE['SNID_'])){
					return $user_id;
				}
				else{
					$cstrong = True;
					$token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
					$h_token = sha1($token);
					$h_snid = sha1($_COOKIE['SNID']);
					$ipaddress = $_SERVER['REMOTE_ADDR'];
					$sqlrole = mysql_query("SELECT role FROM Users WHERE id = '$user_id'");
					$resultrole = mysql_fetch_array($sql,MYSQL_NUM);
					$role = $resultrole[0];
					mysql_query("INSERT INTO Token(token,user_id,role,ip_address) VALUES('$h_token ','$user_id','$role','$ipaddress')");
					mysql_query("DELETE FROM Token WHERE token = '$h_snid'");
					return $user_id;
				}
			}
			return false;
		}
		else{
			return false;
		}
	}

	function isAuth(){
		if(isset($_COOKIE['SNID2'])){
			$d_token = sha1($_COOKIE['SNID2']);
			if(mysql_query("SELECT user_id FROM Token2 WHERE token = '$d_token'")){
				$sql = mysql_query("SELECT user_id FROM Token2 WHERE token = '$d_token'");
				$result = mysql_fetch_array($sql,MYSQL_NUM);
				$user_id = $result[0];
				if(isset($_COOKIE['SNID2_'])){
					return $user_id;
				}
				else{
					$cstrong = True;
					$token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
					$h_token = sha1($token);
					$h_snid = sha1($_COOKIE['SNID2']);
					$resultrole = mysql_fetch_array($sql,MYSQL_NUM);
					$role = $resultrole[0];
					mysql_query("INSERT INTO Token2(token,user_id) VALUES('$h_token ','$user_id')");
					mysql_query("DELETE FROM Token2 WHERE token = '$h_snid'");
					return $user_id;
				}
			}
			return false;
		}
		else{
			return false;
		}
	}

	function getLoginStatus(){
		$status = isloggedin();
		if($status != false){
			return true;
		}
		else{
			return false;
		}
	}

	function getUserId(){
		return isloggedin();
	}

	function getRole(){
		$id = isloggedin();
		if($id!=false){
			$sql2 = mysql_query("SELECT role FROM Users WHERE id = '$id'");
			$result2 = mysql_fetch_array($sql2,MYSQL_NUM);
			$role = $result2[0];
			return $role;
		}
		return false;
	}

	function getLastName(){
		$id = isloggedin();
		if($id!=false){
			$sql3 = mysql_query("SELECT lastname FROM Users WHERE id = '$id'");
			$result3 = mysql_fetch_array($sql3,MYSQL_NUM);
			$ln = $result3[0];
			return $ln;
		}
		return false;
	}

	function getFirstName(){
		$id = isloggedin();
		if($id!=false){
			$sql4 = mysql_query("SELECT firstname FROM Users WHERE id = '$id'");
			$result4 = mysql_fetch_array($sql4,MYSQL_NUM);
			$fn = $result4[0];
			return $fn;
		}
		return false;
	}

	function getEmail(){
		$id = isloggedin();
		if($id!=false){
			$sql4 = mysql_query("SELECT email FROM Users WHERE id = '$id'");
			$result4 = mysql_fetch_array($sql4,MYSQL_NUM);
			$em = $result4[0];
			return $em;
		}
		return false;
	}

	if(isset($_POST["get"])){
		return getLoginStatus();
	}

	function notVerified(){
		$id = isloggedin();
		if($id!=false){
			$sql5 = mysql_query("SELECT status,verified FROM Users WHERE id = '$id'");
			$result5 = mysql_fetch_array($sql5,MYSQL_NUM);
			$s = $result5[0];
			$f = $result5[1];
			if($f==0){
				return "not_verified";
			}
			else{
				if($s!="active"){
					return $s;
				}
			}
		}
		return false;
	}
?>
