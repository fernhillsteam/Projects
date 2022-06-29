<?php
include "db.php";

if(isset($_POST['submit'])){
    

$table_name=mysqli_real_escape_string($con,$_POST['table_name']);

$result = mysqli_query($con,"SHOW TABLES LIKE '".$table_name."'");
if($result->num_rows == 1) {

        echo '<script language="javascript">';
        echo 'alert("Table exists, Please try again")';
        echo '</script>';
}
else {
  
    $table5 = "CREATE TABLE $table_name ( id INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,emp_name VARCHAR(200), salary VARCHAR(200),status tinyint(1) DEFAULT '1', date datetime)";

    /*$query = "INSERT INTO $table_name (`id`, `emp_name`, `salary`, `status`, `date`) VALUES ('$id','$emp_name','$salary','$status','$date')";*/

    $res5=mysqli_query($con,$table5);

        echo '<script language="javascript">';
        echo 'alert("Table Successfully Created")';
        echo '</script>';


}
}
if (isset($_POST['submit'])) {
    $device_id=$_POST['device_id'];
    $mobilenumber=$_POST['mobilenumber'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $date=$_POST['date'];
$query = "INSERT INTO $table_name (`device_id`, `mobilenumber`, `email`, `password`, `date`) VALUES ('$device_id','$mobilenumber','$email','$password','$date')";
$result=mysqli_query($con,$query);

 } 


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Pendios Admin Dashboard

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
  
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="./dashboard.html" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/img/logo-small.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="./dashboard.html" class="simple-text logo-normal">
          Pendios
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="./dashboard.php">
              <i class="nc-icon nc-bank"></i>
              <p>Home</p>
            </a>
          </li>
          <li>
            <li class="active ">
            <a href="./usercreation.php">
              <i class="nc-icon nc-single-02"></i>
              <p>User creation</p>
            </a>
          </li>
          </li>
          <li>
            <a href="#">
              <i class="nc-icon nc-settings"></i>
              <p>Configuration Page</p>
            </a>
          </li>
          <li>
            <a href="./logout.php">
              <i class="fa fa-sign-out" aria-hidden="true"></i>
              <p>Log Out</p>
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
            <a class="navbar-brand" href="javascript:;">Dashboard&nbsp;/&nbsp;Home</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <!-- <div class="collapse navbar-collapse justify-content-end" id="navigation">
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
          </div> -->

        </div>
      </nav>
      <!-- End Navbar -->

       <!-- general form elements -->
            <div class="content">
			 <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">User Creation</h3>
              </div>
              <div class="card-body">
		<form	action="" method="post">
                <div class="row">
                  <div class="col-4">
				    <div class="form-group">
					<label>User Name</label>
                    <input type="text" class="form-control" name="table_name" id="user" placeholder="User Name" >
					</div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
					<label>Device_ID</label>
                    <input type="text" class="form-control" name="device_id" id="device" placeholder="Device_ID">
					</div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
					<label>Mobile Number</label>
                    <input type="text" class="form-control"  name="mobilenumber" id ="mobile" placeholder="Mobile Number">
					</div>
                  </div>
                </div>
				 <div class="row">
                  <div class="col-4">
                    <div class="form-group">
					<label>Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email">
					</div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
					<label>Password</label>
                    <input type="text" class="form-control" name="password" id="pwd" placeholder="Password">
					</div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
					<label>Date</label>
                  <input placeholder="Date & Time" type="date" name="date" id="example" id= "date"class="form-control">
				  </div>
                </div>
				</div>
				 <div class="row">
				 <div class="col-4">
                    <div class="form-group">
					  <input  type="reset" class="btn btn-primary"  name="submit" id="submit"   value="submit">
                 
					</div>
                  </div>
				  </div>
				                 <span id="error_message" class="text-danger "></span>  
                                 <span id="success_message" class="text-success "></span>  
				  </form>
              </div>
              <!-- /.card-body -->
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
              <!-- <ul>
                <li><a href="https://www.creative-tim.com" target="_blank">Creative Tim</a></li>
                <li><a href="https://www.creative-tim.com/blog" target="_blank">Blog</a></li>
                <li><a href="https://www.creative-tim.com/license" target="_blank">Licenses</a></li>
              </ul> -->
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
   <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>
  $(document).ready(function(){  
      $('#submit').on('click',function(){  
           var user = $('#user').val(); 
           var device=$('#device').val();		   
           var mobile= $('#mobile').val();
            var email=$('#email').val();
            var pwd =$('#pwd').val();			
		    var date=$('#date').val();	
		  
           if(user == '' || device == '' || mobile == '' || email == '' || pwd == '' || date == '')  
           {  
               $('#error_message').html("All Fields are required");  
				  
           }  
         
		   else{
			   $('#error_message').html('');  
                $.ajax({  
                     url:"create.php",  
                     method:"POST",  
                     data:{username:user, device_id:device, mobilenumber:mobile, email:email, password:pwd, date:date},  
                     success:function(data){  
					 $('#success_message').html("success");   
                        $("form").trigger("reset");  
                         $('#success_message').fadeIn().html(data);  
                       setTimeout(function(){  
                           $('#success_message').fadeOut("Slow");  
                          }, 2000000);  
                     }  
                });  
           }  
      });  
      });
	  
  </script> -->
  <script src="../assets/js/core/jquery-3.6.0.min.js"></script>
  <script src="../assets/js/core/include-html.min.js"></script>
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

</body>

</html>
