
<?php
include '../inc/header.php';

Session::CheckSession();
 ?>
   <?php					   
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

  $register = $users->addNewUserByAdmin($_POST);
}

if (isset($register)) {
  echo $register;
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
    VTO Admin Dashboard

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

<script" src="imageuploadify.js"></script>
<link href="../assetsimageuploadify.min.css" rel="stylesheet">
<link href="../assetsimageuploadify.min.css" rel="stylesheet">
<link href="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.css" rel="stylesheet">
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



.avatar-upload {
  position: relative;
  max-width: 205px;
  margin: 50px auto;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 34px;
  height: 34px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #ffffff;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: "FontAwesome";
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 192px;
  height: 192px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #f8f8f8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}


.img-thumb {
  max-height: 75px;
  border: 2px solid none;
   border-radius:3px;
  padding: 1px;
  cursor: pointer;
}
.img-thumb-wrapper {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid none;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}



.image-input {
     width: 100px;
     padding: 3px;
     background: #fff;
     //border: 2px dashed dodgerblue;
}
.image-input input {
     display: none;
}
.image-input label {
     display: block;
     width: 100%;
     height: 75px;
     max-height: 100px;
     background: #333;
     border-radius: 10px;
     cursor: pointer;
}

.image-input img {
     width: 100%;
     height: 75px;
     margin: 2px;
}

.imgRemove {
     position: relative;
     bottom: 90px;
     left: 68%;
     background-color: transparent;
     border: none;
     font-size: 30px;
     outline: none;
}
.imgRemove::after {
     content: " \21BA";
     color: #fff;
     font-weight: 900;
     border-radius: 8px;
     cursor: pointer;
}

.small {
     color: #fff;
}

</style>
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
        <a href="./dashboard.php" class="simple-text logo-normal">
          <strong>VTO</strong>
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li >
            <a href="./dashboard.php">
              <i> <img src="../assets/icons/dashboard.png"></i>
              <p><strong>Dashboard</strong></p>
            </a>
          </li>
		  <li>
            <a href="./slider.php">
              <i> <img src="../assets/icons/image.png"></i>
              <p><strong>Add Slider</strong></p>
            </a>
          </li>
		  <li>
            <a href="./gallery.php">
              <i> <img src="../assets/icons/image.png"></i>
              <p><strong>Add Gallery</strong></p>
            </a>
          </li>
		  <li >
            <a href="./members.php">
              <i> <img src="../assets/icons/members.png"></i>
              <p><strong>Manage Members</strong></p>
            </a>
          </li>
		  <li class="active ">
            <a href="./addmember.php">
              <i> <img src="../assets/icons/addmember.png"></i>
              <p><strong>Add Members</strong></p>
            </a>
          </li>
		  <li>
            <a href="../calender1/eventmanage.php">
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
            <a href="?action=adminlogout">
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
            <a class="navbar-brand" href="javascript:;"><strong>Add Member</strong></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <!--<form>
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
                <span class="d-sm-inline d-none"><strong><?php
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?></strong></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="logout.php">Logout</a>

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

       <!-- general form elements -->
            <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
             <!-- <div class="card-header">
                <h5 class="card-title">Notifications</h5>
                <p class="card-category">Handcrafted by our friend <a target="_blank" href="https://github.com/mouse0270">Robert McIntosh</a>. Please checkout the <a href="http://bootstrap-notify.remabledesigns.com/" target="_blank">full documentation.</a></p>
              </div>-->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="card card-plain">
                      <div class="card-header">
                        <h5 class="card-title">Member</h5>
                      </div>
                     <div class="card-body">
					 
					 <div class="container">
    <div class="avatar-upload">
        <div class="avatar-edit">
		<form action="" method="POST"  enctype="multipart/form-data"> 
            <input type='file' id="imageUpload" name="profile" accept=".png, .jpg, .jpeg" />
            <label for="imageUpload"></label>
        </div>
        <div class="avatar-preview">
            <div id="imagePreview" style="background-image: url('../assets/images/profile.png');">
            </div>
        </div>
    </div>
</div>
					 
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="card card-plain">
                      <div class="card-header">
                       <!-- <h5 class="card-title">Notification states</h5>-->
                      </div>
                      <div class="card-body">
					      <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Name" autocomplete="off">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">User Name</label>
      <input type="text" class="form-control" id="inputPassword4" name="username" placeholder="User Name">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Mobile Number</label>
      <input type="text" class="form-control" id="inputEmail4" name="mobile" placeholder="Mobile Number">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Email Address</label>
      <input type="email" class="form-control" id="inputPassword4" name="email" placeholder="Email Adress">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Password</label>
      <input type="text" class="form-control" id="inputCity" name="password" placeholder="Password">
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">Select Role</label>
      <select id="inputState" class="form-control" name="roleid">
        
                  <option name="roleid" value="1" selected='selected'>Admin</option>
                  <option  name="roleid" value="2">Editor</option>
				  <option  name="roleid" value="3">User</option>
                  
      </select>
    </div>
  </div>
  <div class="form-row">
	 <div class="form-group col-md-6">
      <label for="inputState">Select Designation</label>
      <select id="inputState" class="form-control" name="designation">
        
                  <option name="designation" value="1" selected='selected'>Prime</option>
                  <option  name="designation" value="2">Mentor</option>
				  <option  name="designation" value="3">Vice president</option>
                  
      </select>
    </div>
	

  </div>
 <!-- <button name="register" type="submit" class="btn btn-primary">Submit</button>-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		
		<div class="row">
          <div class="col-md-12">
            <div class="card">
              <!--<div class="card-header">
                <h5 class="card-title">Notifications</h5>
                <p class="card-category">Handcrafted by our friend <a target="_blank" href="https://github.com/mouse0270">Robert McIntosh</a>. Please checkout the <a href="http://bootstrap-notify.remabledesigns.com/" target="_blank">full documentation.</a></p>
              </div>-->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="card card-plain">
                      <div class="card-header">
                        <h5 class="card-title">Business</h5>
                      </div>
                      <div class="card-body">
                        <div class="container">
    <div class="avatar-upload">
        <div class="avatar-edit">
            <input type='file' id="logoUpload" name="logo" accept=".png, .jpg, .jpeg" />
            <label for="logoUpload"></label>
        </div>
        <div class="avatar-preview">
            <div id="logoPreview" style="background-image: url('../assets/images/logo.png');">
		
            </div>
        </div>
    </div>
</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="card card-plain">
                      <div class="card-header">
                        <!--<h5 class="card-title">Notification states</h5>-->
                      </div>
                      <div class="card-body">
					     <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Business</label>
      <input type="text" class="form-control" id="inputCity" name="business" placeholder="Business">
    </div>
	<div class="form-group col-md-6">
      <label for="inputEmail4">Business Type</label>
      <input type="text" class="form-control" id="inputEmail4" name="biztype" placeholder="Business Type">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputPassword4">Business description</label>
      <textarea type="email" class="form-control" id="inputPassword4" name="description" placeholder="Business description"></textarea>
    </div>
	<div class="col-md-6" >
       
    </div>
   </div>

    <button name="register" type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
       
   </div>
					  
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
      function imagePreview(fileInput) {
    if (fileInput.files && fileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (event) {
            $('#preview').html('<img src="'+event.target.result+'" width="200" height="auto"/>');
        };
        fileReader.readAsDataURL(fileInput.files[0]);
    }
}

$("#image").change(function () {
    imagePreview(this);
});
   </script>
    
	<!--Profile image-->
	<script>
	  function readImgURL(input) {
		  
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readImgURL(this);
});
	</script>
	
	<!--Profile image-->
	<script>
	  function readlogoURL(input) {
		  
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#logoPreview').css('background-image', 'url('+e.target.result +')');
            $('#logoPreview').hide();
            $('#logoPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#logoUpload").change(function() {
    readlogoURL(this);
});
	</script>
	
	<script>
	$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<div class=\"img-thumb-wrapper card shadow\">" +
            "<img class=\"img-thumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove</span>" +
            "</div>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".img-thumb-wrapper").remove();
          });
          
        });
        fileReader.readAsDataURL(f);
      }
      console.log(files);
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
	</script>


<script>
	  var number = 1;
do {
     function showPreview(event, number) {
          if (event.target.files.length > 0) {
               let src = URL.createObjectURL(event.target.files[0]);
               let preview = document.getElementById(
                    "file-ip-" + number + "-preview"
               );
               preview.src = src;
               preview.style.display = "block";
          }
     }
     function myImgRemove(number) {
          document.getElementById("file-ip-" + number + "-preview").src =
               "https://i.ibb.co/ZVFsg37/default.png";
          document.getElementById("file-ip-" + number).value = null;
     }
     number++;
} while (number < 5);

	</script>
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
