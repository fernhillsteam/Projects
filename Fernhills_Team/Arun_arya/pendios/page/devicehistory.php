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
include('auth_session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Paper Dashboard 2 by Creative Tim
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="https://www.creative-tim.com" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/img/logo-small.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="https://www.creative-tim.com" class="simple-text logo-normal">
          PENDIOS
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
           <li >
            <a href="./dashboard.php">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="./configuration.php">
              <i class="nc-icon nc-diamond"></i>
              <p>Configuration</p>
            </a>
          </li>
        
          <li>
            <a href="./faultlogs.php">
              <i class="nc-icon nc-bell-55"></i>
              <p>Fault-Logs</p>
            </a>
          </li>
          <li class="active ">
            <a href="./devicehistory.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Device-History</p>
            </a>
          </li>
          
          <li class="active-pro">
            <a href="">
          
			  <?php
			
			  require('db.php');
    
			 //****************** to display user id and user name**************************
			   $query ="SELECT * FROM `users` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
               $result = mysqli_query($con, $query) or die(mysql_error());
               
			 while($row = mysqli_fetch_row($result)){
	
	// *************to display Time********************
   
	
			               $query =    "SELECT `c_t` FROM `voltmeter` WHERE `user_id` = '".$row[0]."' order by `time_stamp` DESC limit 1 ";     
			            // $query ="SELECT `voltage`,`current`,`power`,`time_stamp` FROM `users_details` WHERE `user_id`='".$row[0]."'";
                           $result = mysqli_query($con, $query) or die(mysql_error());
			
	                       while($row = mysqli_fetch_row($result)){
		                    ?>
				             <p>Updated Time</p>
				             <div class="numbers">
                            <p class="card-title"><?= $row[0] ?> </p>
					        </div>  
                            <?php 
			  
			
						   }
			 
			 }
		 ?>
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
            <a class="navbar-brand" href="javascript:;">History
</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
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
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
	   <div class="content">
        <div class="row">
	   <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-globe text-warning"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Voltage</p>
		        <?php 
	// *************to display Device status********************
			               $query ="SELECT * FROM `users` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
							  $result = mysqli_query($con, $query) or die(mysql_error());
			
	                       while($row = mysqli_fetch_row($result)){
			               $query =    "SELECT * FROM `voltmeter` WHERE `user_id` = '".$row[0]."' order by `time_stamp` DESC limit 1 ";     
			            // $query ="SELECT `voltage`,`current`,`power`,`time_stamp` FROM `users_details` WHERE `user_id`='".$row[0]."'";
                           $result = mysqli_query($con, $query) or die(mysql_error());
			
	                       while($row = mysqli_fetch_row($result)){
		         ?>
                    <p class="card-title"><?= $row[3] ?> AC V<p>
					  <p class="card-title"><?= $row[6] ?> DC V<p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now        
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-money-coins text-success"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Current</p>
                      <p class="card-title"><?= $row[4] ?> A<p>
					  <p class="card-title"><?= $row[7] ?> A<p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar-o"></i>
                  Last day
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-vector text-danger"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Power</p>
                      <p class="card-title"><?= $row[5] ?> W<p>
			          <p class="card-title"><?= $row[8] ?> W<p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-clock-o"></i>
                  In the last hour
                </div>
              </div>
            </div>
          </div>
		   <?php
						   }  }
			    ?>
      <div class="content">
	  
				  <div class="text-right">
                      <button type="submit" class="btn btn-primary btn-round" onclick="exportTableToCSV( '$time.csv')">Export</button>
                      <button type="submit" class="btn btn-primary btn-round"  onclick="PrintTable()">Print</button>
                  </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
             <div class="card-body">
			  <table class="table" id="tableList" >
                    <thead class=" text-primary">
                      <th>Sl_no</th>
                      <th>AC Voltage</th>
                      <th>AC Current</th>
                      <th>AC Power</th>
					  <th>DC Voltage</th>
                      <th>DC Current</th>
                      <th>DC Power</th>
                      <th>Time Stamp</th>
                    </thead>
                    <tbody>
                        <?php
						 require('db.php');
				 $query ="SELECT * FROM `users` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
                 $result = mysqli_query($con, $query) or die(mysql_error());
               
			     while($row = mysqli_fetch_row($result)){		 
						 
                $query ="SELECT * FROM `voltmeter` WHERE `user_id`='".$row[0]."'";
                $result = mysqli_query($con, $query) or die(mysql_error());
  				if(mysqli_num_rows($result) >0){
  					foreach($result as $row) {
  							?>
  							<tr>
  								<td align="center"><?=$row['Sl_no']; ?></td>
  								<td align="center"><?=$row['ac_v']; ?></td>
  								<td align="center"><?=$row['ac_c']; ?></td>
  								<td align="center"><?=$row['ac_p']; ?></td>
  								<td align="center"><?=$row['dc_v']; ?></td>
  								<td align="center"><?=$row['dc_c']; ?></td>
  								<td align="center"><?=$row['dc_p']; ?></td>
  								<td align="center"><?=$row['c_t']; ?></td>
  							</tr>
  							<?php
  					}
  				}
  				else{
  					?>
  					<tr>
  						<td colspan="6">No Record Found</td>
  					</tr>
  					<?php

  				}
				 }
            ?>
                    </tbody>
                  </table>
                
              </div>
            </div>
          </div>
      
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                <li><a href="https://www.creative-tim.com" target="_blank">Creative Tim</a></li>
                <li><a href="https://www.creative-tim.com/blog" target="_blank">Blog</a></li>
                <li><a href="https://www.creative-tim.com/license" target="_blank">Licenses</a></li>
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i> by Creative Tim
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script>


    function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
  }
  
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}


     </script>
 
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
</body>

</html>