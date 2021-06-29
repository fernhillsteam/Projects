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
  	  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	
						
				<style>
    	
     button{
            background-color: #c80e13;
     		color: white;
			border:none;
            font-family: Helvetica;
     		font-size: 16px;
     		border-radius: 12px;
		}

     button.foo { 
            background-color: #1c9517; 
        }


</style>		
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="./dashboard.php" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/img/logo-small.png">
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
          <li class="active ">
            <a href="./actions.php">
              <i class="nc-icon nc-pin-3"></i>
              <p>Actions</p>
            </a>
          </li>
          <li>
            <a href="./faultlogs.php">
              <i class="nc-icon nc-bell-55"></i>
              <p>Fault-Logs</p>
            </a>
          </li>
          <li>
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
			 } ?>
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
            <a class="navbar-brand" href="javascript:;">Actions</a>
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
	     
        	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js">
               <script>
			   
			   $(document).ready(function () {
                       $("button").click(function () {
						   console.log("hello");
                         $(this).toggleClass('foo');
                        var ele = $(this).attr('id');
                        if ($(this).css("background-color") == "rgb(200, 14, 19)" ) {
                             	update0(ele);

                           } 
                         if($(this).css("background-color") == "rgb(28, 149, 23)"){
       		                   update1(ele);
                          }


                      });
                  });
				  
			</script>
          <div class="col-md-12">
            <div class="card ">
             
			  
              <div class="card-body">
		 <div class="btn-class">
                      <button  id="btn1" >Send SMS On Demand</button>
                      <button  id="btn2" >Update Server On Demand</button>
					  <button  id="btn3" >Authorize Access</button>
                      <button  id="btn4" >ShutDown</button>
			</div>
          
				  </div> 
              </div>
            </div>
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
  function setcolor(ch,data){
switch(ch){
case 1:

    if(data==1){
      $('#btn1').toggleClass('foo');
    }
    break;

case 2:

    if(data==1){
      $('#btn2').toggleClass('foo');
    }
    
    break;

case 3:

    if(data==1){
     $('#btn3').toggleClass('foo');
    }
    
    break;

 case 4:

    if(data==1){
      $('#btn4').toggleClass('foo');
    }
   
    break;

 
}
}
 </script>
 
 <script>
 function disp(){
var xmlhttp = new XMLHttpRequest();
xmlhttp.onload = function() {
  if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.responseText);
   setcolor(1,myObj[0]);
   setcolor(2,myObj[1]);
   setcolor(3,myObj[2]);
   setcolor(4,myObj[3]);
 
  }
};
xmlhttp.open("GET", "actionvalue.php", true);
xmlhttp.send();

}

disp();


 </script>

 <script>
 	function update1(ele) {
 		$.ajax({
            url: "update1.php",
            type: "POST",
            data: {'colname': ele },                   
            success: function(data)
                        {
                           alert(data)                                   
                        }
        });
 		
 	}
 </script>

<script>
	function update0(ele) {
 		$.ajax({
            url: "update0.php",
            type: "POST",
            data: {'colname': ele },                   
            success: function(data)
                        {
                                                            
                        }
        });
 		
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
  <script>
    $(document).ready(function() {
      demo.initGoogleMaps();
    });
  </script>
</body>

</html>