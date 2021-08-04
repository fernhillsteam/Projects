<!doctype html>
<html lang="en">
  <head>
  	<title>Pendios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="../assets/img/pendios.png">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">
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
	<body>
	<section class="ftco-section">
		<div class="container">
			<!-- <div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Pendios</h2>
				</div>
			</div> -->
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(images/bg-1.png);">
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Welcome To User LogIn</h3>
			      		</div>
								<!-- <div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
									</p>
								</div> -->
			      	</div>

							<form  method="post" >
			      		<div class="form-group mb-3">
						<div class="form-field">
			      			<label class="label" for="name">Mobile Number</label>
			      			<input type="text" class="form-control" id="mobile"  placeholder="Mobile Number" autofocus="true"  autocomplete="off">
			      		    <small></small>
					          </div>
						</div>
		            <div class="form-group mb-3">
					<div class="form-field">
		            	<label class="label" for="password">Password</label>
		              <input type="password" class="form-control" id="pwdlu" placeholder="Password"  autofocus="true"  autocomplete="off">
					  <small></small>
					   <input type="checkbox" onclick="myPwd('pwdlu')" >Show Password
		               
					    </div>
				   </div>
		            <div class="form-group">
		            	<button type="submit" id= "submit1" value="Login" class="form-control btn btn-primary rounded submit px-3">Log In</button>
		            </div>
					
				    <div class="row">
                          <div class="col">
						  
                             <a href="#"  data-target="#pwdModal" data-toggle="modal" >Forgot password ?</a>
							
                          </div>
                          <div class="col">
                               <p class="text-right">Log In as Admin!<a href="../adminpage/loginadmin.php">&nbsp;Login</a></p>
                           </div>
                     </div>
				   <div class="form-group d-md-flex">
		            	<!-- <div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div> -->
									<!-- <div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div> -->
		            </div>
		          </form>
		
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>
 
	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>


     

	<!-- forgot password--->
    <div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header text-center border-0">
	 <h3 class="modal-title w-100">Reset Password</h3>
	   <h3 ></h3>
          
 <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close">×</button>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
				
                    <div class="panel-body">
                 
                     
                     <div class="text-center">     
                          <p>If you have forgotten your password you can reset it here.</p>
						  </div>
                            <div class="panel-body">
							   <form action="" method="post">
                               
								    <div class="form-group">
									<div class="form-field">
                                       <input class="form-control input-lg" id="userReset" placeholder="User Name" name="username" type="text" autocomplete="off">
									   <small></small>
                                    </div>
									
					                 </div>
                                    <div class="form-group">
									<div class="form-field">
                                        <input class="form-control input-lg"  id ="newPwd" placeholder="New Password" name="newpwd" type="password">
								    <small></small>
					                 </div>
									</div>
									<div class="form-group">
									<div class="form-field">
                                        <input class="form-control"   id ="confirmPwd" placeholder="Confirm password" name="confirmpwd" type="password">
										<small></small>
					                 </div>
									  <input type="checkbox" onclick="myFunction('confirmPwd', 'newPwd')" >Show Password
		                            </div>
                                    <input type="button" class="btn  btn-primary btn-block" id= "submit2" value=" Reset Password"  >
								
						
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




<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
 <script>
 const mobilenoLA = document.querySelector('#mobile');
 const passwordLA = document.querySelector('#pwdlu');
 const form = document.querySelector('#submit1');
 

 const checkMobileno = () => {
    let valid = false;


    const mobileno = mobilenoLA.value.trim();

    if (!isRequired(mobileno)) {
        showError(mobilenoLA, 'mobile number cannot be blank.');
    } else if (!isMobilenoValid(mobileno)) {
        showError(mobilenoLA, 'please enter valid mobile number.');
    } else {
        showSuccess(mobilenoLA);
        valid = true;
    }
    return valid;
};

 const checkPassword = () => {
    let valid = false;


    const password = passwordLA.value.trim();

    if (!isRequired(password)) {
        showError(passwordLA, 'Password cannot be blank.');
    } else if (!isPasswordSecure(password)) {
        showError(passwordLA, 'Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)');
    } else {
        showSuccess(passwordLA);
        valid = true;
    }

    return valid;
};

const isRequired = value => value === '' ? false : true;


const isMobilenoValid = (mobileno) => {
    const re = new RegExp("^[0-9]{10}$");
    return re.test(mobileno);
};

const isPasswordSecure = (password) => {
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    return re.test(password);
};

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
    let  isMobilenoValid = checkMobileno(),
        isPasswordSecure = checkPassword();
		 
    let isFormValid = isMobilenoValid &&
        isPasswordSecure;

    // submit to the server if the form is valid
    if (isFormValid) {
	
           var user = $('#mobile').val(); 
            var pwd =$('#pwdlu').val();			
			
               $.ajax({ 
			   
                     url:"loginu.php",  
                     method:"POST",  
                     data:{mobilenumber:user, password:pwd},
                     success:function(resp){ 		
alert(resp);					 
			if ($.trim(resp)==="success")
                          {
                              location.href="userdashboard.php";
                             }else{
							 
							 location.href="loginagain.php";
							 
							 }
							 
							 
						  
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
        case 'mobile':
            checkMobileno();
            break;
        case 'pwdlu':
            checkPassword();
            break;
     
    }
}));
 </script>
 <script>
 const usernameLR = document.querySelector('#userReset');
 const passwordLRn = document.querySelector('#newPwd');
 const passwordLRc= document.querySelector('#confirmPwd');
 const form2 = document.querySelector('#submit2');
 
const checkUsernameReset = () => {
    let valid = false;

    const min = 3,
        max = 25;

    const usernamereset = usernameLR.value.trim();

    if (!isRequired(usernamereset)) {
        showErrorReset(usernameLR, 'Username cannot be blank.');
    } else if (!isBetweenreset(usernamereset.length, min, max)) {
        showErrorReset(usernameLR ,`Username must be between ${min} and ${max} characters.`);
		
    }else if (!isUsernameresetValid(usernamereset)) {
        showErrorReset(usernameLR, 'Please Enter Valid UserName');
		
    } else {
        showSuccessReset(usernameLR);
        valid = true;
    }
    return valid;
};

 const checkNewPassword = () => {
    let valid = false;


    const passwordNew = passwordLRn.value.trim();

    if (!isRequired(passwordNew)) {
        showErrorReset(passwordLRn, 'Password cannot be blank.');
    } else if (!isPasswordNew(passwordNew)) {
        showErrorReset(passwordLRn, 'Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)');
    } else {
        showSuccessReset(passwordLRn);
        valid = true;
    }

    return valid;
};

 const checkConfirmPassword = () => {
    let valid = false;

  
    const passwordConfirm = passwordLRc.value.trim();

    if (!isRequired(passwordConfirm)) {
        showErrorReset(passwordLRc, 'Password cannot be blank.');
    } else if (!isPasswordConfirm(passwordConfirm)) {
        showErrorReset(passwordLRc, 'Password does not match');
    } else {
        showSuccessReset(passwordLRc);
        valid = true;
    }

    return valid;
};

const isRequiredreset = value => value === '' ? false : true;

const isBetweenreset = (length, min, max) => length < min || length > max ? false : true;

const isUsernameresetValid = (usernamereset) => {
    const re = new RegExp("^[a-zA-Z\-]+$");
    return re.test(usernamereset);
	
};

const isPasswordNew = (passwordNew) => {
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    return re.test(passwordNew);
};

const isPasswordConfirm = (passwordConfirm) => {
	  const passwordNew1=passwordLRn.value.trim();
      return passwordConfirm!=passwordNew1? false : true ;

};

const showErrorReset = (input, message) => {
    // get the form-field element
    const formFieldReset = input.parentElement;

    // add the error class
    formFieldReset.classList.remove('success');
    formFieldReset.classList.add('error');

    // show the error message
    const errorReset = formFieldReset.querySelector('small');
    errorReset.textContent = message;
};

const showSuccessReset = (input) => {
    // get the form-field element
    const formFieldReset = input.parentElement;

    // remove the error class
    formFieldReset.classList.remove('error');
    formFieldReset.classList.add('success');

    // hide the error message
    const errorReset = formFieldReset.querySelector('small');
    errorReset.textContent = '';
}

form2.addEventListener('click', function (e) {
    // prevent the form from submitting
    e.preventDefault();

    // validate fields
    let isUsernameresetValid = checkUsernameReset(),
	 isPasswordNew = checkNewPassword(),
	 isPasswordConfirm = checkConfirmPassword();
		 
    let isFormValidReset = isUsernameresetValid &&
	isPasswordNew &&
	isPasswordConfirm;

    // submit to the server if the form is valid
    if (isFormValidReset) {
	
           var userReset = $('#userReset').val(); 
            var confirmPwd =$('#confirmPwd').val();			
			
               $.ajax({ 
			     url:"forgotpwd.php",  
                     method:"POST",  
                     data:{username:userReset, newpwd:confirmPwd},  
                     success:function(data){  

                          $("form").trigger("reset");  
						  $('#success_message').html(data); 
             
                     } 
               
					 
                }); 
				window.setTimeout(function() {
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                        $(this).remove(); 
                             });
                         }, 2000);
    }
});


const debounceReset = (fn, delay = 500) => {
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

form2.addEventListener('input', debounceReset(function (e) {
    switch (e.target.id) {
        case 'userReset':
            checkUsernameReset();
            break;
        case 'newPwd':
            checkNewPassword();
            break;
        case 'confirmPwd':
            checkConfirmPassword();
            break;
    }
}));
 </script>
 <script type="text/javascript">
 $(document).ready(function(){  
      $('#submit').click(function(){  
           var username = $('#user').val();  
           var newpwd = $('#newPwd').val();  
		    var confirmpwd = $('#confirmPwd').val(); 
			
		   
           if(username == '' || newpwd == '' || confirmpwd == '')  
           {  
              // $('#error_message').html("All Fields are required");  
				 // alert("All Fields require.");
				 $('#error_message').html('<div class="alert alert-danger" role="alert"><strong>All fields are required</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }  
           else if(newpwd  != confirmpwd ) 
           {  
               //  $('#error_message').html("password do not match");    
                    
                 //  alert("Passwords do not match.");
$('#error_message').html('<div class="alert alert-danger" role="alert"><strong>Passwords do not match</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 				 
           }
		   else{
			  $('#error_message').html('');  
                $.ajax({  
                     url:"forgotpwd.php",  
                     method:"POST",  
                     data:{username:username, newpwd:newpwd},  
                     success:function(data){  
					// $('#success_message').html("success");   
                       $("form").trigger("reset");  
					   $('#success_message').html(data); 
                     //   $('#success_message').fadeIn().html(data);  
                      // setTimeout(function(){  
                        //     $('#success_message').fadeOut("Slow");  
                       //   }, 2000);  
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
 $(document).ready(function(){  
      $('#close').click(function(){
		   $("form").trigger("reset");
		
		  });
		});  
 </script> 
<script type="text/javascript">

         
			 function myFunction(id1,id2) {
  var x = document.getElementById(id1);
  var y = document.getElementById(id2);
  if (x.type === "password" || y.type === "password" ) {
    x.type = "text";
	y.type = "text";
  } else {
    x.type = "password";
	 y.type = "password";
  }
}
</script>

<script type="text/javascript">

function myPwd(id){
	var x = document.getElementById(id);
	 if (x.type === "password") {
    x.type = "text";
	
  } else {
    x.type = "password";
	
  }
}

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
 <script src="bootstrap-4.0.0/dist/js/bootstrap.js"></script>
 <script src="../assets/js/core/bootstrap.min.js"></script>
 
 
 </body>
</html>

