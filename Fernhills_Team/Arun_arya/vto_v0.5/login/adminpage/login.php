<?php
include '../inc/header.php';
Session::CheckAdminLogin();
?>


<?php

if (isset($_POST['login'])) {
	
   $errors= $users->adminLoginAuthotication($_POST);
   
}


$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}



 ?>

<!doctype html>
<html lang="en">
  <head>
  	<title>VTO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="../assets/images/vto-logo.png">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="../assets/css/login-style.css">
    <style>
.form-field input:focus {
    outline: none;
}

small {
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
						<div class="img" style="background-image: url(../assets/images/vto-logo.png);">
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Welcome To Admin LogIn</h3>
			      		</div>
								<!-- <div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
									</p>
								</div> -->
			      	</div>
			      
							<form  method="post"  class="signin-form">
			      		<div class="form-group mb-3">
						    <div class="form-field">
			      			<label class="label" for="name">Username</label>
			      			<input type="text" class="form-control" name="username" placeholder="User Name" autofocus="true" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" autocomplete="off">
							<small><?php echo $errors['username'] ?? '' ?></small>
							</div>
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
						<div class="form-field">
		              <input type="password" class="form-control" id="pwd" name="password" placeholder="Password" value="<?php echo htmlspecialchars($_POST['password'] ?? ''); ?>">
					  <small><?php echo $errors['password'] ?? '' ?></small>
					   
					   </div>
					   <input type="checkbox" onclick="myPwd('pwd')" >Show Password
		            </div>
		            <div class="form-group">
		            	<button type="submit" value="Login" name="login" class="form-control btn btn-primary rounded submit px-3">Log In</button>
						<small><?php echo $errors['checkAdmin'] ?? '' ?></small>
						<small><?php echo $errors['notmatch'] ?? '' ?></small>
						
		            </div>
					
				    <div class="row">
                          <div class="col">
						  
                             <a href="#"  data-target="#pwdModal" data-toggle="modal" >Forgot password ?</a>
							
                          </div>
                          <div class="col">
                               <p class="text-right">Log In as Member!<a href="../page/login.php">&nbsp;Login</a></p>
                           </div>
                     </div>
		          </form>
		<a href="../../index.php" style=""  target="__blank">Go back to Home<i><img src="../assets/icons/home-link.png"></i></a>
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
                                       <input class="form-control input-lg" id="user" placeholder="User Name" name="username" type="text">
                                    </div>
                                    <div class="form-group">
									
                                        <input class="form-control input-lg"  id ="newPwd" placeholder="New Password" name="newpwd" type="password">
								    
									</div>
									<div class="form-group">
                                        <input class="form-control"   id ="confirmPwd" placeholder="Confirm password" name="confirmpwd" type="password">
									  <input type="checkbox" onclick="myFunction('confirmPwd', 'newPwd')" >Show Password
		                            </div>
                                    <input type="reset" class="btn  btn-primary btn-block" id= "submit1" value=" Reset Password" onclick="submit()" >
								
						
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




<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>

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

