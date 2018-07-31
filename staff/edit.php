<?php
  include '../generate_time.php';
  include '../config.php';
  include_once '../token.php';
  
  if(isAuth()){
    $role = getRole();
    if($role=="admin"){
      header("Location:../admin_login");
    }
  }
  else{
      header("Location:../staff_login");
  }

  if(!isloggedin()){
    header("Location:../login");
  }
	  
  if (isset($_GET['aid'])){	  
	$aid = $_GET['aid'];
  }
  $sql = mysql_query("SELECT Appointments.bdate, Appointments.btime, Users.firstname, Users.lastname, Patient.hkid, Appointments.doctor_id FROM Appointments , Patient, Users WHERE Appointments.aid = '$aid' ");
  $result = mysql_fetch_array($sql,MYSQL_NUM);
  $date = $result[0];
  $timeslot = $result[1];
  $firstname = $result[2];
  $lastname = $result[3];
  $hkid = $result[4];
  $doctor = $result[5];
  $print_time=get_time_options("All","$date","$doctor");
  
  if (isset($_POST['submit2'])){
	$new_date = $_POST['date'];
	$new_timeslot = $_POST['timeslot'];
	//mysql_query("UPDATE Appointments SET Appointments.bdate='$new_date', Appointments.btime='$new_timeslot' WHERE Appointments.aid = '$aid'");
	mysql_query("UPDATE Appointments SET bdate='$new_date' WHERE aid = '$aid'");
  }
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Staff Panel - </title>
    <meta name="description" content="Staff Panel -- ">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">
    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>
<body>


        <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="index"> <i class="menu-icon fa fa-home"></i>Home </a>
                    </li>
                    <li class="active">
                        <a href="add-booking"> <i class="menu-icon fa fa-check-square"></i>Add Booking </a>
                    </li>
					<li class="active">
                        <a href="payment"> <i class="menu-icon fa fa-dollar"></i>Make payment </a>
                    </li>
					<li class="active">
                        <a href="manage"> <i class="menu-icon fa fa-clock-o"></i>Manage Timetable </a>
                    </li>
					<li class="active">
                        <a href="search"> <i class="menu-icon fa fa-search"></i>Search Patient </a>
                    </li>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/account" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>

                                <a class="nav-link" href="../panel_logout?logout=<?php echo $_COOKIE['SNID2_'];?>"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Home</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active"><a href="index">Home</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
		
			<div class="col-sm-4">
			<h3>Booking:</h3>
			</div>
			
			<div class="col-md-12">
				<div class='container margin_10_10'>
                  <div class='row'>
                    <div class='col-12 ml-auto'>
                      <div class='box_form'>
                        <form action='index' method='POST'>
                          <div class='row'>
                            <div class='col-md-6 '>
                              <div class='form-group'>
                                <label for='hkid' class='col-12 col-form-label'>First Name</label>
                                <input type='text' id='firstname' name='firstname' class='form-control' value='<?php echo $firstname;?>' disabled/>
                                <div id='invalidhkid' class='invalid-feedback' style='display:none;'></div>
                              </div>
                            </div>
                            <div class='col-md-6'>
                              <div class='form-group row'>
                              <label for='hkid' class='col-12 col-form-label'>Last Name</label>
                              <input class='form-control' type='text' name='lastname' id='lastname' value='<?php echo $lastname;?>' disabled />
                              <div id='invaliddob' class='invalid-feedback' style='display:none;'></div>
                              </div>
                              </div>
                          </div>
                          <div class='row'>
                            <div class='col-md-6 '>
                              <div class='form-group'>
                                <label for='hkid' class='col-12 col-form-label'>HKID</label>
                                <input type='text' id='hkid' value='<?php echo $hkid;?>' name='hkid' class='form-control'  disabled/>
                                <div id='invalidhkid' class='invalid-feedback' style='display:none;'></div>
                              </div>
                            </div>
                            <div class='col-md-6'>
                              <div class='form-group row'>
                              <label for='date' class='col-12 col-form-label'>Date</label>
                              <input class='form-control'  type='date' name='date' id='date' value='<?php echo $date;?>'/>
                              
                              </div>
                              </div>
                          </div>
                          <!-- /row -->
                          <div class='row'>
                            <div class='col-md-6'>
                              <div class='form-group'>
                                <label for='timeslot' class='col-12 col-form-label'>Time</label>
                                <select name="timeslot" class='form-control'>
									<?php echo $print_time; ?>
								</select>
                              </div>
                            </div>
                          </div>
						  <p class='text-center add_top_30'><form action='index' method='POST'><input type='submit' value='submit' name='submit2' id='submit2'></input></form></p>
                        </form>
                      </div>
                      <!-- /box_form -->
                    </div>
			</div>
			
        </div><!--/.col-->

    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.min.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="assets/js/lib/vector-map/country/jquery.vmap.world.js"></script>
    <script>
        ( function ( $ ) {
            "use strict";

            jQuery( '#vmap' ).vectorMap( {
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: [ '#1de9b6', '#03a9f5' ],
                normalizeFunction: 'polynomial'
            } );
        } )( jQuery );
    </script>
	<script>
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!

		var yyyy = today.getFullYear();
		if(dd<10){
				dd='0'+dd;
		}
		if(mm<10){
				mm='0'+mm;
		}
		var someDate = new Date();
		var numberOfDaysToAdd = 14;
		someDate.setDate(someDate.getDate() + numberOfDaysToAdd);

		var sdd = someDate.getDate();
		var smm = someDate.getMonth() + 1;
		var sy = someDate.getFullYear();

		if(sdd<10){
				sdd='0'+sdd;
		}
		if(smm<10){
				smm='0'+smm;
		}
		someDate=sy+'-'+smm+'-'+sdd;
		document.getElementsByName("date")[0].setAttribute('max', someDate);
		today = yyyy+'-'+mm+'-'+dd;
		document.getElementsByName("date")[0].setAttribute('min', today);
	</script>

</body>
</html>
