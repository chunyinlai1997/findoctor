<?php
	include 'config.php';
	include_once 'token.php';
	$isLoggedin = getLoginStatus();
	if(!$isLoggedin){
		header("Location:login");
	}
  else{
    $role = getRole();
    if(isAuth()){
      if($role=="admin"){
        header("Location:admin/index");
      }
      else if($role=="staff"){
        header("Location:staff/index");
      }
    }

    if($role=="patient"){
      header("Location:index");
    }
    else if($role=="admin"){
      header("Location:admin_login");
    }
    else{
      $fname = getFirstName();
    }
  }

  function ac_fail(){
		if($_GET["ac"]=="WRONG"){
			return "Wrong staff code! Try Again!";
		}
		else if($_GET["ac"]=="NO_SUBMIT"){
			return "Empty staff code Submission! Try Again.";
		}
	}
?>
<html>
<head>
  <title>Staff Login --Doctor Appointment System --  ABC Medical Company</title>
	<?php include 'head-info.php';?>
  <link href='./css/panel_login.css' rel='stylesheet' />
</head>
<body class="bg-dark">
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

  <div class = "container">
  	<div class="wrapper">
  		<form action="action_stafflogin" method="post" name="Login_Form" class="form-signin">
          <div class="row justify-content-center">
            <div class="col-md-12">
            <?php
              $error1 = "<div class='alert alert-danger'><a class='close'data-dismiss='alert' href='#'>×</a>";
              $error2 = "</div>";
              if(isset($_GET["ac"])){
                $msg = ac_fail();
                echo $error1.$msg.$error2;
              }
            ?>
            </div>
          </div>
          <h1 class="form-signin-heading" style="color:blue;">STAFF PANEL</h1>
  		    <h3 class="form-signin-heading">Welcome Back, <?php echo $fname;?> !</h3>
          <p class="form-signin-heading">Please input your 6-digit staff code.</p>
          <input type="password" class="form-control" placeholder="Your 6-digit staffcode" name="staffcode" minlength="6" maxlength="6" required />
          <br>
          <button class="btn btn-lg btn-primary btn-block"  name="submit" value="submit" type="submit">Login</button>
          <hr>
          <small><a href="#0">Please contact the tech team if you have any diffculties or forget satff code.</a></small>
          <a href="index" class="btn btn-lg btn-secondary btn-block">Back to Home</a>

      </form>
  	</div>
  </div>
  <?php include 'footer.php';?>
  <?php include 'member_modal.php';?>
  <script src="./js/jquery-2.2.4.min.js"></script>
  <script src="./js/common_scripts.min.js"></script>
  <script src="./js/functions.js"></script>
  <script src="./js/header.js"></script>
</body>
</html>
