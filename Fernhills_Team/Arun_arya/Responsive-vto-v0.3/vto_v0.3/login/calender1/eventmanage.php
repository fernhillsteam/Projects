<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php
include '../inc/header.php';
Session::CheckSession();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/images/vto-logo.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   VTO Member Dashboard
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/calendar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
  
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="success">
      <div class="logo">
        <a href="./dashboard.php" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/images/vto-logo.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="#" class="simple-text logo-normal">
          <strong>VTO</strong>
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="../adminpage/dashboard.php">
              <i> <img src="../assets/icons/dashboard.png"></i>
              <p><strong>Dashboard</strong></p>
            </a>
          </li>
		  <li>
            <a href="../adminpage/slider.php">
              <i> <img src="../assets/icons/image.png"></i>
              <p><strong>Add Slider</strong></p>
            </a>
          </li>
		  <li>
            <a href="../adminpage/gallery.php">
              <i> <img src="../assets/icons/image.png"></i>
              <p><strong>Add Gallery</strong></p>
            </a>
          </li>
		  <li>
            <a href="../adminpage/members.php">
              <i> <img src="../assets/icons/members.png"></i>
              <p><strong>Manage Members</strong></p>
            </a>
          </li>
		  <li>
            <a href="../adminpage/addmember.php">
              <i> <img src="../assets/icons/addmember.png"></i>
              <p><strong>Add Members</strong></p>
            </a>
          </li>
		  <li class="active ">
            <a href="./eventmanage.php">
              <i> <img src="../assets/icons/events.png"></i>
              <p><strong>Manage Events</strong></p>
            </a>
          </li>
          <li>
            <a href="#">
              <i> <img src="../assets/icons/analytics.png"></i>
              <p><strong>Analytics</strong></p>
            </a>
          </li>
		  <li>
            <a href="#">
              <i> <img src="../assets/icons/contacts.png"></i>
              <p><strong>Contact</strong></p>
            </a>
          </li>
      <!--    <li>
            <a href="">
              <i class="nc-icon nc-settings"></i>
              <p>Configuration Page</p>
            </a>
          </li>-->
          <li>
            <a href="#">
              <i> <img src="../assets/icons/logout.png"></i>
              <p><strong>Log Out</strong></p>
            </a>
          </li>

        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->

       <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;"><strong>Manage Events</strong></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
           <!-- <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>-->
            <ul class="navbar-nav">
			
			  <li class="nav-item d-flex align-items-center">
              
			  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user me-sm-1"></i>
				  <span class="d-sm-inline d-none"><strong>
				<?php
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?></strong></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Logout</a>

                </div>
            </li>
              <!--<li class="nav-item">
                <a class="nav-link btn-magnify" href="javascript:;">
                  <i class="nc-icon nc-layout-11"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-bell-55"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="javascript:;">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>-->
            </ul>
          </div> 

        </div>
      </nav>
      <!-- End Navbar -->
	   
	   <div class="content">
	       <div class="row">
          <div class="col-md-12">
                <div class="row">
			 <div class="col-md-4">
					<div class="btn-group">
				<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
				<button class="btn btn-default" data-calendar-nav="today">Today</button>
				<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
				   </div>
			</div>
			<div class="col-md-4">
			<div class="btn-group">
				<button class="btn btn-warning" data-calendar-view="year">Year</button>
				<button class="btn btn-warning active" data-calendar-view="month">Month</button>
				<button class="btn btn-warning" data-calendar-view="week">Week</button>
				<button class="btn btn-warning" data-calendar-view="day">Day</button>
			</div>
			</div>
			<div class="col-md-4">
						<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Create an Event
</button>-->
			</div>

					</div>
                 
                
              </div>
            </div>
			<div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <!--<h5 class="card-title">Edit Profile</h5>-->
				
			</div>
            		
			  <div class="card-body">
			    <div class="card-title">
				        <h5></h5>
                </div>
			  <div class="card-body">
                <div id="showEventCalendar"></div>
			  </div>
			  </div>	
             
            </div>
          </div>
		 <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Create an event</h4>
              </div>
              <div class="card-body">
			  <form method="post" action="process.php">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="inputAddress2" class="form-label">Program</label>
                        <input type="text" name="title" class="form-control" id="inputAddress2" placeholder="program name">
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="inputAddress2" class="form-label">Venue</label>
                        <input type="text" name="description" class="form-control" id="inputAddress2" placeholder="venue">
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="inputAddress2" class="form-label">Start Date</label>
                        <input type="date" name="sdate" class="form-control" id="date" value="" placeholder="Event Date">
						 <input type="hidden" name="edate" class="form-control" id="edate" value="" placeholder="Apartment, studio, or floor">
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="inputEmail4" class="form-label">Start-Time</label>
                        <input type="time" class="form-control" name="stime" id="" placeholder="Start Time">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="inputPassword4" class="form-label">End-Time</label>
                        <input type="time" class="form-control" name="etime" id="" placeholder="End Time">		
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="inputAddress" class="form-label">Entry-Fee</label>
                        <input type="text" name="efee" class="form-control" id="" placeholder="entry fee">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <input type="submit" class="btn btn-primary btn-round" name="save" value="submit">
                    </div>
					<div class="col-md-4">
                      <input type="reset" class="btn btn-primary btn-round" name="clear" value="Clear">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
		  <!-- create event Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <!--<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create an Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	     <form method="post" action="process.php">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Program</label>
                        <input type="text" class="form-control" name="title" placeholder="Program" >
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Venue</label>
                        <input type="text" class="form-control" name="description" placeholder="Venue" >
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Start Date</label>
                        <input type="text" class="form-control" name="sdate" placeholder="Start Date" >
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>End Date</label>
                        <input type="text" class="form-control" name="edate" placeholder="End Date" >
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Select a time</label>
                        <input type="time" class="form-control" name="appt" placeholder="End Date" >			
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Entry Fee</label>
                        <input type="text" class="form-control" name="cdate" placeholder="End Date" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <input type="submit" class="btn btn-primary btn-round" name="save" value="submit">
                    </div>
					<div class="col-md-4">
                      <input type="reset" class="btn btn-primary btn-round" name="clear" value="Clear">
                    </div>
                  </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
  
</div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">

            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, All rights reserved by Vokkaligara Trade Organisation Dashboard
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>





  <!--   Core JS Files   -->



  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.jqueryui.min.js"></script>
   <script>
    $(document).ready(function(){
    $('#tableList').DataTable();
	console.log("hello");
         });
	function PrintTable() {
       var tab = document.getElementById('tableList');
	   console.log(tab)
       var style = "<style>";
                style = style + "table {width: 100%;font: 17px Calibri;}";
                style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
                style = style + "padding: 2px 3px;text-align: center;}";
                style = style + "</style>";

             var win = window.open('', '', 'height=700,width=700');
             win.document.write(style);          //  add the style.
             win.document.write(tab.outerHTML);
             win.document.close();
             win.print();
        }
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
  <script>
  $(function () {
    $('#datetimepicker1').datetimepicker();
 });
</script>
 <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/events.js"></script>

<script type="text/javascript">
         $('#dateTime').ejDateTimePicker({
       dateTimeFormat: "dddd, MMMM dd, yyyy hh:mm:ss tt",
       timePopupWidth: "150px",
       timeDisplayFormat: "hh:mm:ss tt",
       width: '300px'
    });
         $('#edate').ejDateTimePicker({
       dateTimeFormat: "dddd, MMMM dd, yyyy hh:mm:ss tt",
       timePopupWidth: "150px",
       timeDisplayFormat: "hh:mm:ss tt",
       width: '300px'
    });
    </script>
</script>
<script type="text/javascript">
	window.onload = function() {
    var src = document.getElementById("dateTime"),
        dst = document.getElementById("edate");
    src.addEventListener('input', function() {
        dst.value = src.value;
    });
};
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
</body>

</html>
