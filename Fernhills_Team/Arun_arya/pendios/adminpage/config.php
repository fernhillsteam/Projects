

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/pendios.png">
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

  
</head>
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
            <a href="./usercreation.php">
              <i class="nc-icon nc-single-02"></i>
              <p>User creation</p>
            </a>
          </li>
          <li class="active ">
            <a href="">
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
            <a class="navbar-brand" href="javascript:;">Configuration</a>
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

      <?php
	
	     require('db.php');
	
		$id = $_GET['edit'];
		
        $query ="SELECT * FROM `configuration` WHERE `user_id`='".$id."'";
	
       $result = mysqli_query($con, $query) or die(mysql_error());
	   $result = mysqli_query($con, $query);  
      while($row = mysqli_fetch_array($result))  
      { 
  
  ?>

          <div class="content">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <!--<li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Settings</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Settings 2</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings 3</a></li>-->
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  <form class="form-horizontal" action="" method="POST">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Device Id:</label>
                        <div class="col-sm-10">
						<div class="form-field">
                          <input type="text" name= "device" class="form-control" id="device" placeholder="Device Id" value="<?=$row['device_id']?>">
						  <small></small>
				            </div>
                        </div>
                      </div>
                      <div class="form-group row">
					 
                        <label for="inputEmail" class="col-sm-2 col-form-label">Mobile No:</label>
                        <div class="col-sm-10">
						<div class="form-field">
                          <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile No" value="<?=$row['mobile_number']?>">
						  <small></small>
				            </div>
                        </div>
						
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">auth code:</label>
                        <div class="col-sm-10">
						<div class="form-field">
                          <input type="text" name="auth" class="form-control" id="auth" placeholder="auth code" value="<?=$row['auth_code']?>">
						  <small></small>
				            </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">server link:</label>
                        <div class="col-sm-10">
						<div class="form-field">
                           <input type="text" name="server" class="form-control" id="server" placeholder="server link" value="<?=$row['server_link']?>">
						   <small></small>
				            </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">APN:</label>
                        <div class="col-sm-10">
						<div class="form-field">
                          <input type="text" name="apn" class="form-control" id="apn" placeholder="APN" value="<?=$row['apn']?>">
						  <small></small>
				            </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">User Name:</label>
                        <div class="col-sm-10">
						<div class="form-field">
                          <input type="text"  name="user" class="form-control" id="user" placeholder="User Name" value="<?=$row['username']?>">
						  <small></small>
				            </div>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Password:</label>
                        <div class="col-sm-10">
						  <div class="form-field">
                          <input type="text"  name="pwd" class="form-control" id="pwd" placeholder="Password" value="<?=$row['password']?>">
						   <small></small>
				            </div>
                        </div>
                      </div>
					   <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Location:</label>
                        <div class="col-sm-10">
						<div class="form-field">
                          <input type="text" name="location" class="form-control" id="location" placeholder="Location" value="<?=$row['location']?>">
						  <small></small>
				            </div>
                        </div>
                      </div>
					   <div class="form-group row">
                        <label for="inputSkills"  class="col-sm-2 col-form-label">Address:</label>
                        <div class="col-sm-10">
						<div class="form-field">
                          <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?=$row['address']?>">
						  <small></small>
				            </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm">
		
						   <input class="btn  btn-primary" id ="submit" value="Submit" type="button" >		
                        </div>
                      </div>
					  				 
                    </form>
               
                  </div>
				  
	<?php

	  }
	  
?>	  
                  <!-- /.tab-pane -->
                  <!-- <div class="tab-pane" id="timeline">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">hello</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>-->
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
			<span  id="error_message" class="text-center"></span> 
		    <span  id="success_message" class="text-center"></span>
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

 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <script>
const usernameEl = document.querySelector('#user');
const deviceidEl = document.querySelector('#device');
const mobilenoEl = document.querySelector('#mobile');
const passwordEl = document.querySelector('#pwd');


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




const isPasswordSecure = (password) => {
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    return re.test(password);
};

const isMobilenoValid = (mobileno) => {
    const re = new RegExp("^[0-9]{10}$");
    return re.test(mobileno);
};

const isDateTime = (mobileno) => {
   const re = new RegExp("^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01])");
    return re.test(datetime);
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
        isPasswordValid = checkPassword(),
		 ismobilenoValid = checkMobileno();
         
    let isFormValid = isUsernameValid &&
                      isDeviceidValid &&
                      isPasswordValid &&
                       ismobilenoValid;
    // submit to the server if the form is valid
    if (isFormValid) {
	
        
           var user_id = '<?php echo $id ;?>';	  
           var device = $('#device').val();  
           var mobile = $('#mobile').val();  
		   var auth = $('#auth').val(); 
		   var server = $('#server').val();  
		   var apn = $('#apn').val();  
		   var username = $('#user').val();  
	       var pwd= $('#pwd').val();  
       	   var location = $('#location').val();  
		   var address = $('#address').val();  
		   
           if(device == '' || mobile == '' || auth == ''||server == ''|| apn == ''|| username == ''|| pwd == ''|| location == ''|| address == '')  
           {  
             $('#error_message').html('<div class="alert alert-danger" role="alert"><strong>All fields are required</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
			 
        
           }  
          
		      else{
				  $.ajax({  
                     url:"insert_config.php",  
                     method:"POST",  
                     data:{user_id:user_id, device:device ,mobile:mobile, auth:auth, server:server, apn:apn, user:username, pwd:pwd, location:location, address:address},  
                     success:function(data){  
	
                          $('#success_message').html(data);  
                    		
                         
                     }
				 
                });  	
		
            }   
			   window.setTimeout(function() {
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                        $(this).remove(); 
                             });
                         }, 2000);
           
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
<!-- <script>  

$(document).ready(function() {
      $('#submit').click(function(){ 
           var user_id = '<?php echo $id ;?>';	  
           var device = $('#device').val();  
           var mobile = $('#mobile').val();  
		   var auth = $('#auth').val(); 
		   var server = $('#server').val();  
		   var apn = $('#apn').val();  
		   var username = $('#user').val();  
	       var pwd= $('#pwd').val();  
       	   var location = $('#location').val();  
		   var address = $('#address').val();  
		   
           if(device == '' || mobile == '' || auth == ''||server == ''|| apn == ''|| username == ''|| pwd == ''|| location == ''|| address == '')  
           {  
             $('#error_message').html('<div class="alert alert-danger" role="alert"><strong>All fields are required</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 
			 
        
           }  
          
		      else{
				  $.ajax({  
                     url:"insert_config.php",  
                     method:"POST",  
                     data:{user_id:user_id, device:device ,mobile:mobile, auth:auth, server:server, apn:apn, user:username, pwd:pwd, location:location, address:address},  
                     success:function(data){  
	
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
