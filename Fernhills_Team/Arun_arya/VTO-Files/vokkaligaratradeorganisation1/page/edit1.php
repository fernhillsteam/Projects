
<?php
include '../inc/header.php';
Session::CheckSession();

 ?>

 <?php
if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateUserByUser($userid, $_POST);

}

if (isset($updateUser)) {
  echo $updateUser;
}

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
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
.form-field input:focus {
    outline: none;
}

.form-field.error input {
    border-color: #dc3545;
}

.form-field.success input {
    border-color: #28a745;
}


.form-field small {
    color: #dc3545;
}
</style>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="./dashboard.php" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/images/vto-logo.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="./dashboard.php" class="simple-text logo-normal">
          <strong>VTO</strong>
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
           <li class="active ">
		  <a href="./dashboard.php">
			<i> <img src="../assets/icons/editprofile.png"></i>
              <p><strong>Edit Profile</strong></p>
            </a>
          </li>
          <li>
            <a href="#">
			  <i> <img src="../assets/icons/meeting.png"></i>
              <p><strong>Manage Meetings</strong></p>
            </a>
          </li>

          <li>
            <a href="faultlogs.php">
			  <i> <img src="../assets/icons/businessman.png"></i>
              <p><strong>Business Referrals</strong></p>
            </a>
          </li>
          <li >
            <a href="?action=userlogout">
              <i> <img src="../assets/icons/logout.png"></i>
              <p><strong>log out</strong></p>
            </a>
          </li>

          <li class="active-pro">
            <a href="">
			
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
            <a class="navbar-brand" href="javascript:;"><strong>Edit Profile</strong></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
       
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
                  <a class="dropdown-item" href="?action=userlogout">Logout</a>

                </div>
            </li>
            
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->

       <!-- general form elements -->
            <div class="content">
			 <div class="card">
              <div class="card-header">
            <!--  <h3 class="card-title">User Creation</h3>-->
              </div>
              <div class="card-body">
<?php

    $getUinfo = $users->getUserInfoById($userid);
    if ($getUinfo) {

     ?>			  

		<form action="" method="POST" >
                <div class="row">
				<!--<div class="col-6">
				    <div class="form-group">
					<label>Table Name</label>
                    <input type="text" class="form-control" name="table_name" id="tablename" placeholder="Table Name" >
					</div>
                  </div>-->
			
                  <div class="col-6">
				       <div class="form-group">
					   <div class="form-field">
					<label>Name</label>
                    <input type="text" class="form-control" name="name" id="user" placeholder="Name" value="<?php echo $getUinfo->name;?>" autocomplete="off">
					    <small></small>
					</div>
					</div>
                  </div>
                  <div class="col-6">
				   <div class="form-group">
                    <div class="form-field">
					<label>User Name</label>
                    <input type="text" class="form-control" name="username" id="device" placeholder="User Name" value="<?php echo $getUinfo->username; ?>" autocomplete="off">
					<small></small>
					</div>
				   </div>
                  </div>
				  </div>
				  
				  <div class="row">
                  <div class="col-6">
				   <div class="form-group">
                    <div class="form-field">
					<label>Mobile Number</label>
                    <input type="text" class="form-control"  name="mobile" id ="mobile" placeholder="Mobile Number" value="<?php echo $getUinfo->mobile; ?>" autocomplete="off">
					    <small></small>
					</div>
					</div>
					</div>
                  
                
                  <div class="col-6">
				  <div class="form-group">
                    <div class="form-field">
					<label>Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $getUinfo->email; ?>" autocomplete="off">
					    <small></small>
					</div>
					</div>
                  </div>
				  </div>
			
				 <div class="row">
				 <div class="col-6">
				 <div class="form-group">
                    <div class="form-field">
                  <input type="submit" class="btn  btn-primary"  name="update"  value="Update"  >		  
					</div>
					</div>
                  </div>
				  </div>
				     <!-- <div class="mb-3 text-center">
								
                                 <span id="success_message" class="text-success "></span>  
								 <span id="error_message" class="text-danger"></span> 
			           </div> -->
					   
					
                   					   
				  </form>
				  
				   <?php }?>	
              </div>
              <!-- /.card-body -->
            </div>
		  <span  id="error_message" class="text-center"></span> 
		  <span  id="success_message" class="text-center"></span>

            
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
                </script>, All rights reserved by Vokkaligara Trade Organisation Dashboard
              </span>
            </div>
          </div>
        </div>
      </footer>
    
              </div>
          </div>

      
  <!--   Core JS Files   -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
const usernameEl = document.querySelector('#user');
const deviceidEl = document.querySelector('#device');
const mobilenoEl = document.querySelector('#mobile');
const emailEl = document.querySelector('#email');
const passwordEl = document.querySelector('#pwd');
const datetimeEl = document.querySelector('#date');

const form = document.querySelector('#submit');


const checkUsername = () => {
    let valid = false;

    const min = 3,
        max = 25;

    const username = usernameEl.value.trim();

    if (!isRequired(username)) {
        showError(usernameEl, 'Username cannot be blank.');
    } else if (!isBetween(username.length, min, max)) {
        showError(usernameEl, `Username must be between ${min} and ${max} characters.`);
    } else {
        showSuccess(usernameEl);
        valid = true;
    }
    return valid;
};

const checkDeviceid = () => {
    let valid = false;


    const deviceid = deviceidEl.value.trim();

    if (!isRequired(deviceid)) {
        showError(deviceidEl, 'Device ID  cannot be blank.');
    }else if (!isDeviceidValid(deviceid)) {
        showError(deviceidEl, 'please enter valid device ID.');
    }  else {
        showSuccess(deviceidEl);
        valid = true;
    }
    return valid;
};

const checkMobileno = () => {
    let valid = false;


    const mobileno = mobilenoEl.value.trim();

    if (!isRequired(mobileno)) {
        showError(mobilenoEl, 'mobile number cannot be blank.');
    } else if (!isMobilenoValid(mobileno)) {
        showError(mobilenoEl, 'please enter valid mobile number.');
    } else {
        showSuccess(mobilenoEl);
        valid = true;
    }
    return valid;
};

const checkEmail = () => {
    let valid = false;
    const email = emailEl.value.trim();
    if (!isRequired(email)) {
        showError(emailEl, 'Email cannot be blank.');
    } else if (!isEmailValid(email)) {
        showError(emailEl, 'Email is not valid.')
    } else {
        showSuccess(emailEl);
        valid = true;
    }
    return valid;
};

const checkPassword = () => {
    let valid = false;


    const password = passwordEl.value.trim();

    if (!isRequired(password)) {
        showError(passwordEl, 'Password cannot be blank.');
    } else if (!isPasswordSecure(password)) {
        showError(passwordEl, 'Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)');
    } else {
        showSuccess(passwordEl);
        valid = true;
    }

    return valid;
};

const checkDateTime = () => {
    let valid = false;


    const datetime = datetimeEl.value.trim();

    if (!isRequired(datetime)) {
        showError(datetimeEl, 'Date and Time cannot be blank.');
    }  else { 
		showSuccess(datetimeEl);
        valid = true;
    }

    return valid;
};


const isEmailValid = (email) => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};

const isPasswordSecure = (password) => {
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    return re.test(password);
};

const isMobilenoValid = (mobileno) => {
    const re = new RegExp("^[0-9]{10}$");
    return re.test(mobileno);
};

//const isDateTime = (mobileno) => {
  //  const re = new RegExp("^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01])");
    //return re.test(datetime);
//};
const isDeviceidValid = (deviceid) => {
    const re = new RegExp("^[0-9a-zA-Z]+$");
    return re.test(deviceid);
};

const isRequired = value => value === '' ? false : true;

const isBetween = (length, min, max) => length < min || length > max ? false : true;


const showError = (input, message) => {
    // get the form-field element
    const formField = input.parentElement;

    // add the error class
    formField.classList.remove('success');
    formField.classList.add('error');

    // show the error message
    const error = formField.querySelector('small');
    error.textContent = message;
};

const showSuccess = (input) => {
    // get the form-field element
    const formField = input.parentElement;

    // remove the error class
    formField.classList.remove('error');
    formField.classList.add('success');

    // hide the error message
    const error = formField.querySelector('small');
    error.textContent = '';
}


form.addEventListener('click', function (e) {
    // prevent the form from submitting
    e.preventDefault();

    // validate fields
    let isUsernameValid = checkUsername(),
	    isDeviceidValid = checkDeviceid(),
        isEmailValid = checkEmail(),
        isPasswordValid = checkPassword(),
		 ismobilenoValid = checkMobileno(),
         isDateTimeValid = checkDateTime();
		 
    let isFormValid = isUsernameValid &&
        isDeviceidValid &&
        isEmailValid &&
        isPasswordValid &&
        ismobilenoValid &&
		isDateTimeValid;

    // submit to the server if the form is valid
    if (isFormValid) {
	
           var user = $('#user').val(); 
           var device=$('#device').val();		   
           var mobile= $('#mobile').val();
            var email=$('#email').val();
            var pwd =$('#pwd').val();			
		    var date=$('#date').val();	
               $.ajax({  
                     url:"create.php",  
                     method:"POST",  
                     data:{user:user, device_id:device, mobile:mobile, email:email, pwd:pwd, date:date},  
                     success:function(data){  
					
                        $("form").trigger("reset");  
                         $('#success_message').html(data);  
                          setTimeout(function() {
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                     $(this).remove(); 
                            });
                       }, 2000);
                     }  
					 
					 
                }); 
    }
});


const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};

form.addEventListener('input', debounce(function (e) {
    switch (e.target.id) {
        case 'user':
            checkUsername();
            break;
		case 'device':
            checkDeviceid();
            break;	
		case 'mobile':
            checkMobileno();
            break;	
        case 'email':
            checkEmail();
            break;
        case 'pwd':
            checkPassword();
            break;
         case 'date':
            checkDAteTime();
            break;
    }
}));
</script>
<!--<script>

  $(document).ready(function(){  
      $('#submit').on('click',function(){ 
	       var tname = $('#tablename').val(); 
           var user = $('#user').val(); 
           var device=$('#device').val();		   
           var mobile= $('#mobile').val();
            var email=$('#email').val();
            var pwd =$('#pwd').val();			
		    var date=$('#date').val();	

		  
           if(user == '' || device == '' || mobile == '' || email == '' || pwd == '' || date == '')  
           {  
               $('#error_message').html('<div class="alert alert-danger" role="alert"> <strong>All fields are required</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');  
		
           }  		   
         
		   else{
			   
                $.ajax({  
                     url:"create.php",  
                     method:"POST",  
                     data:{table_name:tname ,user:user, device_id:device, mobile:mobile, email:email, pwd:pwd, date:date},  
                     success:function(data){  
					
                        $("form").trigger("reset");  
                         $('#success_message').html(data);  
           
                     }  
                });  
           }  
		   window.setTimeout(function() {
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                        $(this).remove(); 
                             });
                         }, 2000);
             });  
      });
	  
  </script>-->
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
