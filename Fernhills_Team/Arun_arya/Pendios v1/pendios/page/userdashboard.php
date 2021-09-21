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
   Pendios IoT Dashboard
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
</head>
				<style>
				.image--cover {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  margin: 20px;

  object-fit: cover;
  object-position: center right;
}

			#copyright{
				color:#000080;
			}
			.container:hover .overlay {
  opacity: 1;
}
			</style>
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
        <a href="./userdashboard.php" class="simple-text logo-normal">
          PENDIOS
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
           <li class="active ">
		  <a href="./dashboard.php">
          <i class="fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
      <!--    <li>
            <a href="#">
              <i class="fas fa-cogs"></i>
              <p>Configuration</p>
            </a>
          </li>-->

          <li>
            <a href="faultlogs.php">
              <i class="nc-icon nc-bell-55"></i>
              <p>Fault-Logs</p>
            </a>
          </li>
          <li >
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

			 while($row = mysqli_fetch_array($result)){

	// *************to display Time********************
                $username = $row["username"];
                $device_id = $row["device_id"];
		
		  	    $user = substr($username, 0, 2);
	            $voltTable = $user."".-$device_id."-vm";
			
	  $query = "SELECT * FROM `".$voltTable."` WHERE `device_id` = '".$device_id."'order by `sl_no` DESC limit 1 ";  
     
      $result = mysqli_query($con, $query);  

      while($row = mysqli_fetch_array($result))  
      { 
		                    ?>
				             <p style="color:red;">Updated Time</p>
				             <div class="numbers">
                          <b>  <p style="color:black;"class="card-title"><?= $row['c_t'] ?> </p></b>
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
            <a class="navbar-brand" href="javascript:;">Dashboard</a>
		   </div>

    <?php

			  require('db.php');

			 //****************** to display user id and user name**************************
			   $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
               $result = mysqli_query($con, $query) or die(mysql_error());

			 while($row = mysqli_fetch_array($result)){
              $device_id=$row['device_id']
    ?>

		  <div class="text-center" >

			 <p><?= $row['username'] ?></p>
			 <p>Device_ID :</p>
			 <p><?= $row['device_id'] ?></p>
 	      </div>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
		 
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
		 

            <ul class="navbar-nav">


    <div class="collapse navbar-collapse" id="navigation">
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
   
			  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php
		$image=$row['image'];
		if($image==0){
			echo '<img src="../profileimage/defaultprofile.png" id="imgDisplay" width="40" height="40" class="rounded-circle">';
		}else{
			?>
			<img src="../profileimage/<?php echo $image; ?>" id="imgDisplay" width="40" height="40" class="rounded-circle">
			<?php
		}
		?>
         
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item"href="#" data-toggle="modal" data-target="#basicModal">Edit Profile</a>
		
          <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>

      </li>   
    </ul>
  </div>
         
			
            </ul>
          </div>
			
		</div>
		 

      </nav>
      <!-- End Navbar -->
	  <!-- basic modal -->

<div id="basicModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header text-center border-0">
	 <h3 class="modal-title w-100">Change Profile</h3>
	   <h3 ></h3>
          
 <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close">×</button>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
				
                    <div class="panel-body">            
                    <div class="text-center">     
						  </div>
                            <div class="panel-body">
							  <form action="" method="post" enctype="multipart/form-data">
		
							   <div class="form-group text-center">
							  
							   	<?php
		                        $image=$row['image'];
		                               if($image==0){
			                             echo '<image src="../profileimage/defaultprofile.png" onclick="triggerClick()" id="profileDisplay" class="image--cover">';
		                                 }else{
			                             ?>
			                                <image src="../profileimage/<?php echo $image; ?>" onclick="triggerClick()" id="profileDisplay" class="image--cover">
			                            <?php
		                             }
	                          	?>
								
							 </div>
							 <input type="file" name="profileImage" onchange="displayImage(this)" id="profileImage" style="display:none;" class="form-control">
							   
						      <div class="form-group">
					
							    <input type="button" class="btn  btn-primary btn-block" value="Upload" id="but_upload" >
							  </div>
	
                	          </form>

                        </div>
                                  
                </div>
				                 
            </div>
			                    <br><span id="error_message" class="text-center "></span>  
                                 <span id="success_message" class="text-center "></span> 
      </div>

  </div>
  </div>
</div>
</div>
  <?php
			  
		       }
			 
		 
		 
	 	 ?>
		 
		 
	    <?php

				  $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
               $result = mysqli_query($con, $query) or die(mysql_error());
              
			 while($row = mysqli_fetch_array($result)){
				  
                            $username = $row["username"];
                            $device_id = $row["device_id"];
		
		  	                $user = substr($username, 0, 2);
	                        $voltTable = $user."".-$device_id."-vm";
			
	  $query = "SELECT * FROM `".$voltTable."` WHERE `device_id` = '".$device_id."'order by `sl_no` DESC limit 1 ";  
     
      $result = mysqli_query($con, $query); 
						
						 
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

	                     
							    while($row = mysqli_fetch_array($result)){
				  
                            $username = $row["username"];
                            $device_id = $row["device_id"];
		
		  	                $user = substr($username, 0, 2);
	                        $voltTable = $user."".-$device_id."-vm";
							
			            $query = "SELECT * FROM `".$voltTable."` WHERE `device_id` = '".$device_id."'order by `sl_no` DESC limit 1 ";  
     
                         $result = mysqli_query($con, $query); 
	                       while($row = mysqli_fetch_array($result)){
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

                    <p class="card-title"><?= $row['ac_v'] ?> V <small>AC</small><p>
					  <p class="card-title"><?= $row['dc_v'] ?> V <small>DC</small><p>
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
                      <p class="card-title"><?= $row['ac_c'] ?> A<p>
					  <p class="card-title"><?= $row['dc_c'] ?> A<p>
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
                      <p class="card-title"><?= $row['ac_p'] ?> W<p>
			          <p class="card-title"><?= $row['dc_p'] ?> W<p>
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
						   } }  
						   
			 
			    ?>


	<div class="row">
	 <div class="col-md-12">
	
	  <div class="card">
              <div class="card-header">
               <!-- <h4 class="card-title">Device Status</h4>-->
              </div>
              <div class="card-body">
                <div class="row">			

	 <div class="col-lg col-md-6 col-6 ml-auto text-center">
		<div><i id="ind1" class='fas fa-circle ' ></i></div>
				 <p class="card-category text-center">Short Circuit</p>
                </div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		   <div><i id="ind2" class='fas fa-circle '></i></div>
				<p class="card-category text-center">Shutdown</p>
				</div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		     <div><i id="ind3" class='fas fa-circle '></i></div>
				<p class="card-category text-center">Overload</p>
				</div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		   <div><i id="ind4" class='fas fa-circle '></i></div>
				<p class="card-category text-center">Tampering</p>
		        </div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		<div><i id="ind5"class='fas fa-circle '></i></div>
				<p class="card-category text-center">Health</p>

				</div>
                  </div>

                  </div>
              </div>
		
			
			     
            
	   </div>
	   </div>
	  <?php
	// *************to display Device status********************
			               $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
							  $result = mysqli_query($con, $query) or die(mysql_error());

	                     
							    while($row = mysqli_fetch_array($result)){
				  
                            $device_id = $row["device_id"];  
							?>
<script>
var id = <?php echo $device_id; ?>;

</script>
<?php
								}
								
								?>

 <script>
if(typeof(EventSource) !== "undefined") {
  var source = new EventSource("indicatordata.php?a="+id);

  source.onmessage = function(event) {
   var eventid=event.lastEventId;
if(eventid==id){
   var myObj = JSON.parse(event.data);
     indcolor(1,myObj[0]);
     indcolor(2,myObj[1]);
     indcolor(3,myObj[2]);
     indcolor(4,myObj[3]);
	 indcolor(5,myObj[4]);
}

  };
} 

</script>
<script>
			
  function indcolor(ch,data){
	
switch(ch){

case 1:
     if (data == 1) {
    ind1.style.color = 'green';
	
  } else {
       ind1.style.color = 'red';
  }
    break;

case 2:

        if (data == 1) {

    ind2.style.color = 'green';
  } else {
      ind2.style.color = 'red';
  }
    break;
  

case 3:

        if (data == 1) {

    ind3.style.color = 'green';
  } else {
      ind3.style.color = 'red';
  }
    break;


 case 4:

       if (data == 1) {

    ind4.style.color = 'green';
  } else {
      ind4.style.color = 'red';
  }
    break;

case 5:

        if (data == 1) {

    ind5.style.color = 'green';
  } else {
      ind5.style.color = 'red';
  }
    break;
 
}

}
 </script>

			<div class="row">
		  <div class="col-lg-12 col-md-14 col-sm-10">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Voltage VS Time</h5>
                <p class="card-category">Bar Chart</p>
              </div>

              <div class="card-body ">

			  <canvas id="myChart" width="400" height="auto"></canvas>
	    <?php
	             $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
                 $result = mysqli_query($con, $query) or die(mysql_error());

			     while($row = mysqli_fetch_array($result)){

                          $username = $row["username"];
                          $device_id = $row["device_id"];
		
		  	               $user = substr($username, 0, 2);
	                       $voltTable = $user."".-$device_id."-vm";
							
			    $query = "SELECT `ac_v`,`dc_v`,`c_t` FROM `".$voltTable."` WHERE `device_id` = '".$device_id."' ";  
   
                $result = mysqli_query($con, $query) or die(mysql_error());
			    $data = array();


			    foreach($result as $value){
			           $data[] = $value;
			   }

		?>
			   <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.1/dist/chart.min.js"></script>

			    <script >


				 var data = <?php echo json_encode($data); ?>;
				 console.log(data);
                 var ac_v =[];
				 var dc_v =[];
				 var c_t  = [];

				 for(var i in data){
					ac_v .push( data[i].ac_v);
					dc_v .push( data[i].dc_v);
					 c_t.push(data[i].c_t);

				 }

				 var datas={
					 labels:c_t,
					 datasets:[{

						 label:'AC Voltage',
						 backgroundColor:'#FF8C00',
						 borderColor:'red',
						 data:ac_v
					 },
					 {

						 label:'DC Voltage',
						 backgroundColor:'#FFD700',
						 borderColor:'red',
						 data:dc_v
					 }]
				 }

			    var ctx =document.getElementById("myChart");

				var graph ={
					 type:'bar',
					 data:datas
					}

			              var bargraph = new Chart(ctx,graph);
				           console.log(bargraph);
                        </script>

                  <?php
			    }

			 ?>
               </div>
			</div>
           </div>
          </div>
		  					  
				<?php	  
					  }else{		 
				  ?>	
				
			  <div class="content">
                     
					  <div class="text-center">
                       <h1>No Data </h1>
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
                </script>,Copyright <a id="copyright" href="https://imbrutetechnologies.com/pwa/fernhill/index.php" target="_blank"><strong>Fernhill Technologies</strong></a>. All Rights Reserved
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

    $("#but_upload").click(function(){

        var fd = new FormData();
        var files = $('#profileImage')[0].files;
        var id = 3169;
        // Check file selected or not
        if(files.length > 0 ){
           fd.append('profileImage',files[0]);

           $.ajax({
              url: 'imageupload.php',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
				
                 if(response!="invalid"){
					
				    $("#imgDisplay").attr("src",response); 
                    $("#imgDisplay").show(); // Display image element
					 $('#success_message').html("<div class='alert alert-success' role='alert'> <strong>successfully uploaded</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                 }else if(response=="invalid"){
					 $('#error_message').html("<div class='alert alert-danger' role='alert'> <strong>Invalid format. Only jpg / jpeg/ png /gif format allowed</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				 }else{
                    $('#error_message').html("<div class='alert alert-danger' role='alert'> <strong>fail to upload</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                 }
              },
           });
		   	
        }else{
         
		   $('#error_message').html("<div class='alert alert-danger' role='alert'> <strong>Please select a Profile Image.</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
		setTimeout(function() {
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                        $(this).remove(); 
                             });
                         }, 2000);
    });
	

});

</script>
 <script>

function triggerClick(){
	document.querySelector('#profileImage').click();
}

function displayImage(e){
	
	if(e.files[0]){
		var reader = new FileReader();
		
		reader.onload = function(e){
			 document.querySelector('#profileDisplay').setAttribute('src',e.target.result);
			 
		}
		reader.readAsDataURL(e.files[0]);
	}
	
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
