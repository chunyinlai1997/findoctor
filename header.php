<!DOCTYPE html>

<?php
	include_once 'config.php';
	include_once 'token.php';

	function header_strings(){
		$isLoggedin = getLoginStatus();
		$link = "";
		$word = "";
		$greet = "";
		$getcook = "";
		if($isLoggedin){
			$getcook = $_COOKIE['SNID_'];
			$greet = getFirstName();
			$greet = "Hi,".$greet.".";

			$role = getRole();
			if($role=="patient"){
				$link = "profile";
				$word = "Profile";
				$link = "
				<li class='submenu'>
					<a href='#0' class='show-submenu'>Profile<i class='icon-down-open-mini'></i></a>
					<ul>
						<li><a href='my_booking'>My Booking Record</a></li>
						<li><a href='my_payment'>My Payment Record</a></li>
						<li><a href='personal_info'>Personal Info</a></li>
						<li><a href='logout?logout=$getcook'>Logout</a></li>
					</ul>
				</li>
				";
			}
			else if($role=="staff"){
				$link = "staff_login";
				$word ="Staff Panel";
				$link = "<li class='submenu'><a href='".$link."' class='show-submenu'>".$word."</a></li><li class='submenu'><a href='logout?logout=$getcook' class='show-submenu'>Logout</a></li>";
			}
			else if($role=="admin"){
				$link = "admin_login";
				$word ="Admin Panel";
				$link = "<li class='submenu'><a href='".$link."' class='show-submenu'>".$word."</a></li><li class='submenu'><a href='logout?logout=$getcook' class='show-submenu'>Logout</a></li>";
			}

		}

		$basic1 = "
		<header class='header_sticky'>
				<div class='container'>
					<div class='row'>
						<div class='col-lg-3 col-7'>
							<div id='logo_home'>
								<h1><a href='index' title='Findoctor'>Findoctor</a></h1>
							</div>
						</div>
						<nav class='col-lg-9 col-5'>
							<a class='cmn-toggle-switch cmn-toggle-switch__htx open_close' href='#0'><span>Menu mobile</span></a>
		";

		$basic2 = "
		<div class='main-menu'>
			<ul>
				<li class='submenu'>
					<a href='index' class='show-submenu' style='padding-right:18px;'>Home</a>
				</li>
				<li class='submenu'>
					<a href='#0' class='show-submenu'>About<i class='icon-down-open-mini'></i></a>
					<ul>
						<li><a href='aboutus'>About Us</a></li>
						<li><a href='faq'>FAQ</a></li>
					</ul>
				</li>
				<li class='submenu'>
					<a href='#0' class='show-submenu'>Book Now<i class='icon-down-open-mini'></i></a>
					<ul>
						<li><a href='list_clinic'>Clinic</a></li>
						<li><a href='list_specialization'>Specialization</a></li>
						<li><a href='list_doctor'>Doctor</a></li>
					</ul>
				</li>
				$link
			</ul>
		</div>
		<!-- /main-menu -->
	</nav>
	</div>
	</div>
	<!-- /container -->
	</header>
	<!-- /header -->
		";

		$notyetlogin = "
		<ul id='top_access' style='color:white;'>
			<li><a href='login'><i class='pe-7s-user'></i></a></li>
			<li><a href='register'><i class='pe-7s-add-user'></i></a></li>
		</ul>
		";
		//<a href='login' class='btn btn-success' role='button'>Login</a></a>
		//<a href='register' class='btn btn-info' role='button'>Register</a></a>

		$haslogin1 = "";


		$haslogin2 = "";

		return array($basic1,$basic2,$notyetlogin,$haslogin1,$haslogin2,$greet);
	}


	if(isset($_POST["generate"])){

	}

	function gen_header(){
		list($basic1,$basic2,$notyetlogin,$haslogin1,$haslogin2,$greet) = header_strings();
		$isLoggedin = getLoginStatus();
		$output = "";
		if($isLoggedin){
			//$user_id = getUserId();
			//$sql= mysql_query("SELECT firstname, lastname, profile_image FROM Users WHERE id = $user_id ") or die(mysql_error());
			//$row= mysql_fetch_array($sql,MYSQL_NUM);
			//$name =  " ".$row[0] . " ". $row[1]. " ";
			//$profile_img = $row[2];

			//<a href='profile'><figure><img src='$profile_img' alt='' /></figure></a>
			//$append = "<figure><img src='' alt='user icon' height='40' width='40' /></figure>";
			//$greet
			$output .= $basic1 . $haslogin1 . $basic2;
		}
		else{
			$output .= $basic1 . $notyetlogin . $basic2;
		}
		echo $output;
	}

	/*
	<li class='submenu'>
		<a href='#0' class='show-submenu'>Pages<i class='icon-down-open-mini'></i></a>
		<ul>
			<li><a href='./list.php'>List page</a></li>
			<li><a href='./grid-list.php'>List grid page</a></li>
			<li><a href='./list-map.php'>List map page</a></li>
			<li><a href='./detail-page.php'>Detail page</a></li>
			<li><a href='./detail-page-2.php'>Detail page 2</a></li>
			<li><a href='./detail-page-3.php'>Detail page 3</a></li>
			<li><a href='./blog-1.php'>Blog</a></li>
			<li><a href='./badges.php'>Badges</a></li>
			<li><a href='./login.php'>Login</a></li>
			<li><a href='./login-2.php'>Login 2</a></li>
			<li><a href='./register-doctor.php'>Register Doctor</a></li>
			<li><a href='./register.php'>Register</a></li>
			<li><a href='./contacts.php'>Contacts</a></li>
		</ul>
	</li>
	<li class='submenu'>
		<a href='#0' class='show-submenu'>Elements<i class='icon-down-open-mini'></i></a>
		<ul>
			<li><a href='./icon-pack-1.php'>Icon pack 1</a></li>
			<li><a href='./icon-pack-2.php'>Icon pack 2</a></li>
			<li><a href='./icon-pack-3.php'>Icon pack 3</a></li>
			<li><a href='404.php'>404 page</a></li>
		</ul>
	</li>
	*/

?>
