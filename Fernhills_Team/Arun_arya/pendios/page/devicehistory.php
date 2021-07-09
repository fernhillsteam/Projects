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
  <link rel="icon" type="image/png" href="../assets/img/pendios.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  
  <title>
    Pendios
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
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="./dashboard.php" class="simple-text logo-mini">
          <div class="logo-image-small">
             <img src="../assets/img/pendios.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="./dashboard.php" class="simple-text logo-normal">
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
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fas fa-cogs"></i>
              <p>Configuration</p>
            </a>
          </li>
        
          <li>
            <a href="#">
              <i class="nc-icon nc-bell-55"></i>
              <p>Fault-Logs</p>
            </a>
          </li>
          <li class="active ">
            <a href="./devicehistory.php">
              <i class="fas fa-history"></i>
              <p>Device-History</p>
            </a>
          </li>
          
          <li class="active-pro">
            <a href="">
          
			  <?php
			
			  require('db.php');
    
			 //****************** to display user id and user name**************************
			   $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
               $result = mysqli_query($con, $query) or die(mysql_error());
               
			 while($row = mysqli_fetch_row($result)){
	
	// *************to display Time********************
   
	
			               $query =    "SELECT `c_t` FROM `voltmeterp` WHERE `user_id` = '".$row[0]."' order by `time_stamp` DESC limit 1 ";     
			            // $query ="SELECT `voltage`,`current`,`power`,`time_stamp` FROM `users_details` WHERE `user_id`='".$row[0]."'";
                           $result = mysqli_query($con, $query) or die(mysql_error());
			
	                       while($row = mysqli_fetch_row($result)){
		                    ?>
				             
                             <p style="color:red;">Updated Time</p>
				             <div class="numbers"><b>
						   <p style="color:black;"class="card-title"><?= $row[0] ?> </p></b>
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
            <a class="navbar-brand" href="javascript:;">History</a>
          </div>
		  <?php

			  require('db.php');

			 //****************** to display user id and user name**************************
			   $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
               $result = mysqli_query($con, $query) or die(mysql_error());

			 while($row = mysqli_fetch_row($result)){

    ?>

		  <div class="text-center" >

			 <p><?= $row[1] ?></p>
			 <p>Device_ID :</p>
			 <p><?= $row[2] ?></p>
 	      </div>
		  	  <?php
			 }
			 ?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
       
            <ul class="navbar-nav">
           
            <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Settings</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="logout.php">Logout</a>

                </div>
              </li>
            
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
	  <?php

				  $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
               $result = mysqli_query($con, $query) or die(mysql_error());
              
			 while($row = mysqli_fetch_row($result)){
				  

						 $query =    "SELECT * FROM `voltmeterp` WHERE `user_id` = '".$row[0]."' order by `time_stamp` DESC limit 1 " ;     
						 $result= mysqli_query($con, $query);
						 $row = mysqli_fetch_row($result);
						 
							  if(mysqli_num_rows($result)==1){
								  

								  ?>
	   <div class="content">
        <div class="row">
	   <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
			          <?php 
	// *************to display Device status********************
			               $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
							  $result = mysqli_query($con, $query) or die(mysql_error());
			
	                       while($row = mysqli_fetch_row($result)){
			               $query =    "SELECT * FROM `voltmeterp` WHERE `user_id` = '".$row[0]."' order by `time_stamp` DESC limit 1 ";     
			            // $query ="SELECT `voltage`,`current`,`power`,`time_stamp` FROM `users_details` WHERE `user_id`='".$row[0]."'";
                           $result = mysqli_query($con, $query) or die(mysql_error());
			
	                       while($row = mysqli_fetch_row($result)){
		         ?>
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                       <i> <img src="icons/voltage.png"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Voltage</p>
                    <p class="card-title"><?= $row[3] ?> V <small>AC</small><p>
					  <p class="card-title"><?= $row[6] ?> V <small>DC</small><p>
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
                      <i> <img src="icons/current.png"></i>
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
                       <i> <img src="icons/power.png"></i>
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
		  </div>
		   <?php
						   }  }
			    ?>
					<div class="row">  
	<div class="col">
	  <div class="card">
              <div class="card-header">
               <!-- <h4 class="card-title">Device Status</h4>-->
              </div>
              <div class="card-body">
                <div class="row">
                 <?php
 
   $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
               
                  $result = mysqli_query($con, $query) or die(mysql_error());
               	
			 while($row = mysqli_fetch_row($result)){
				 //********* to update Device status depending up on Sl_no increase*********
                         $query ="SELECT * FROM `indicator` WHERE `user_id` = '".$row[0]."' order by `Sl_no` DESC limit 1 ";
                         $result = mysqli_query($con, $query) or die(mysql_error());
               
			     while($row = mysqli_fetch_row($result)){
					 
                    $short  =$row[2];
					$shutdown=$row[3];
					$overload=$row[4];
					$tamper=$row[5];
					$health=$row[6];
		 
?>				
				 <div class="col-lg col-md-6 col-6 ml-auto text-center">
				<?php echo  "<div style='color: ".($short == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				 <p class="card-category text-center">Short Circuit</p>
                </div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		        <?php echo  "<div style='color: ".($shutdown == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				<p class="card-category text-center">Shutdown</p>
				</div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		        <?php echo  "<div style='color: ".($overload == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				<p class="card-category text-center">Overload</p>
				</div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		        <?php echo  "<div style='color: ".($tamper == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				<p class="card-category text-center">Tampering</p>
		        </div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		        <?php echo  "<div style='color: ".($health == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				<p class="card-category text-center">Health</p>
				
				</div>
				
 
<?php                  
			 } }

?>	
			  
                  </div>
                   
                  </div>
              </div>
            </div>	
		</div>	
				<div class="row">
				  <div class="col-lg-12 col-md-12 col-sm-14">
	<?php			  
      $current_date = date('Y-m-d');
	  ?>
	
				  <div class="text-right">
                      <button type="submit" class="btn btn-primary btn-round" onclick="exportTableToCSV( '<?php echo $current_date; ?>.csv')">Export</button>
                      <button type="submit" class="btn btn-primary btn-round"  onclick="PrintTable()">Print</button>
                  </div>
              </div>
			  </div>
		<div class="row">	  
         <div class="col-lg-12 col-md-12 col-sm-14"> 
            <div class="card">
             <div class="card-body">
			  <div class="table-responsive-md">
			  <table class="table  table-hover w-auto" id="tableList" >
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
				 $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
                 $result = mysqli_query($con, $query) or die(mysql_error());
               
			     while($row = mysqli_fetch_row($result)){		 
						 
                $query ="SELECT * FROM `voltmeterp` WHERE `user_id`='".$row[0]."'";
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
          </div>   
      </div>
	  					  
				<?php	  
					  }else{		 
				  ?>	
				
			  <div class="content">
                     
					  <div class="text-center">
                       <h1>No data </h1>
					  </div>
			       
				 </div> 
		
			<?php
			 			 
			
				}
					
				 }
			// closing connection
                mysqli_close($con); 	
    ?>

      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, All rights reserved by PENDIOS IoT Dashboard
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
 <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script> 
 <script>
    $(document).ready(function(){
    $('#tableList').DataTable();

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