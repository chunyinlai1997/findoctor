<?php
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
  
  if(isset($_POST["checkin"])){
	  //$message="confirm check in?";
	  //echo "<script type='text/javascript'>confirm("$message");</script>";
	  mysql_query("UPDATE Appointments SET status='confirmed'");
  }
  
  if(isset($_POST["cancel"])){
	  //$message="confirm cancel this booking?";
	  //echo "<script type='text/javascript'>confirm("$message");</script>";
	  mysql_query("UPDATE Appointments SET status='cancelled'");
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
			
			<div class="col-sm-8" align="right">
			<a class="btn btn-primary btn-lg" href="add-booking" role="button">Add Booking</a>
			</div>
			
			<div class="col-md-12">
				<table id="bootstrap-data-table" class="table table-striped table-bordered">
					<thead>
					  <tr>
						<th>Time</th>
						<th>Last Name</th>
						<th>HKID</th>
						<th>Check In</th>
						<th>Edit/Cancel</th>
					  </tr>
					</thead>
					<tbody>
					  <?php
					  $date=date("Y/m/d");
					  $sql2 = mysql_query("SELECT Appointments.btime, Users.lastname, Patient.hkid, Appointments.aid FROM Appointments , Patient, Users WHERE bdate = '$date' AND Appointments.patient_id = Patient.user_id AND Appointments.patient_id = Users.id AND Appointments.status='booked'");
					  while($row2 = mysql_fetch_array($sql2,MYSQL_NUM))
					  {
					  ?>
					  <tr>
						   <td><?php echo $row2[0]; ?></td>
						   <td><?php echo $row2[1]; ?></td>
						   <td><?php echo $row2[2]; ?></td>
						   <td><form method="post" action="index.php"><input type="submit" class="btn btn-outline-primary btn-sm" name="checkin" id="checkin" value="Check In"></input></form></td>
						   <td><form method="post" action="index.php"><a role="button" href="edit?aid=<?php echo $row2[3]?>" class="btn btn-outline-success btn-sm">Edit</a>
						   <input type="submit" class="btn btn-outline-danger btn-sm" name="cancel" id="cancel" value="Cancel"></input></form></td>
					  </tr>
					  <?php
					  }
					  ?>
					</tbody>
				</table>
			</div>
			
            </div><!--/.col-->

        </div> <!-- .content -->
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

</body>
</html>
