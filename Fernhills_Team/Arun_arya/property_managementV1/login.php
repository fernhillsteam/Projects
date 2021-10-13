<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Madhunivas</title>

    <link rel="shortcut icon" href="assets/images/fav.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawsom-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>

<body class="h-100">
    <div class="container-fluid full-bg h-100">
        <div class="container h-100">
            <div class="row no-margin h-100">
                <div class="bg-layer d-flex col-md-4">
                    <div class="login-box row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-unlock-alt"></i> login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-user-plus"></i> Register</a>
                            </li>

                        </ul>
                        <div class="tab-content w-100" id="myTabContent">
                            <div class="tab-pane   fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
                               <div class="login-tab">
                               <!--<h3>login</h3>-->
                                
                               <div class="form-row">
                                  
                                   <input placeholder="Email" id="email" class="form-control form-control-sm" type="text"autocomplete="off">
                               </div>
                               
                               <div class="form-row">
                                  
                                   <input placeholder="Password" id="pwd" class="form-control form-control-sm" type="password">
								   
                               </div>
                               <input type="checkbox" onclick="myPwd('pwd')" >  Show Password
                                <div class=" forget">
                                  
                                   <p> <a href="#"  data-target="#pwdModal" data-toggle="modal" >Forgot password ?</a></p>
								   
                                <button class="btn btn-success btn-sm" id ="submit" >Sign In</button>
                               </div>
                                </div>
                             
                            </div>
                            <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="profile-tab">
                                 <div class="login-tab">
                                <!-- <h3>User login</h3>-->
                                
                               <div class="form-row">
                                  
                                   <input placeholder="Name" id="rname" class="form-control form-control-sm" type="text" autocomplete="off" >
                               </div>
                               
                               <div class="form-row">
                                  <select id = "ownertype" class="form-control" name="ownertype">
		                                 <option value="">Owner Type</option>
		                                 <option value="Owner">Owner</option>
		                                 <option value="Builder">Builder</option>
		                                 <option value="Agent0">Agent</option>
                                  </select>
                                  </div>
							   
							   <div class="form-row">
                                  
                                   <input placeholder="Email" id="remail" class="form-control form-control-sm" type="text" autocomplete="off" >
                               </div>
							   
                                <div class="form-row">
                                  
                                   <input placeholder="Password" id="rpwd" class="form-control form-control-sm" type="text" autocomplete="off">
                               </div>
                                <div class="form-row">
                                  
                                   <input placeholder="Confirm Password" id="rcpwd" class="form-control form-control-sm" type="text" autocomplete="off">
                               </div>
                               <div class=" forget">
                                  <br>
                                  
                                <button class="btn btn-success w-100 btn-sm" id="submit1">Click to Signup</button>
                               </div>
                                </div>
                            </div>

                        </div>




                    </div>
                </div>
            </div>

            <div class="foter-credit">
              
            </div>
        </div>

    </div>
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
                                        <input class="form-control"   id ="fcpwd" placeholder="Confirm password" name="confirmpwd" type="password">
										<small></small>
					                 </div>
									  <input type="checkbox" onclick="myFunction('fcpwd', 'newPwd')"> Show Password
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
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

 $(document).ready(function(){  
      $('#submit').click(function(){  
           var email = $('#email').val();  
           var pwd = $('#pwd').val();  

			
		   
           if(email == '' || pwd == '')  
           {  
              // $('#error_message').html("All Fields are required");  
				  alert("All Fields require.");
				// $('#error_message').html('<div class="alert alert-danger" role="alert"><strong>All fields are required</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }  
          
		   else{
			 
                $.ajax({  
                     url:"logincheck.php",  
                     method:"POST",  
                     data:{email:email, pwd:pwd},  
                     success:function(data){ 		
				 alert(data);
			if ($.trim(data)==="success")
                          {
                              location.href="index.php";
                             }else{
							  alert("Try Agin");
							 
							 }
							 
							 
						  
					 }  
                });  
           }  
		  
          });  
      });
  

  $(document).ready(function(){  
      $('#submit1').click(function(){ 
            var name = $('#rname').val(); 
            var ownerty=$('#ownertype :selected').val();
alert(ownerty);			
            var email= $('#remail').val();
            var pwd=$('#rpwd').val();
            var cpwd =$('#rcpwd').val();

            if(name == '' || ownerty == '' || email == '' || pwd == '' ||cpwd == '')  
           {  
              // $('#error_message').html("All Fields are required");  
				  alert("All Fields require.");
				// $('#error_message').html('<div class="alert alert-danger" role="alert"><strong>All fields are required</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }else if(pwd!==cpwd){
			   
			   alert("Inncorrect Password");
			   
		   }else{			
               $.ajax({  
                     url:"registration.php",  
                     method:"POST",  
                     data:{name:name, ownerty:ownerty, email:email, pwd:pwd},  
                     success:function(data){  
					         alert("successfully updated");
                     }  
					 
					 
                }); 
		   }
		    });  
      });
		
</script>	

<script type="text/javascript">
 $(document).ready(function(){  
      $('#submit2').click(function(){  
           var username = $('#userReset').val();  
           var newpwd = $('#newPwd').val();  
		    var confirmpwd = $('#fcpwd').val(); 
			
		   
           if(username == '' || newpwd == '' || confirmpwd == '')  
           {  
              // $('#error_message').html("All Fields are required");  
				  alert("All Fields require.");
				// $('#error_message').html('<div class="alert alert-danger" role="alert"><strong>All fields are required</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }  
           else if(newpwd  != confirmpwd ) 
           {  
               //  $('#error_message').html("password do not match");    
                    
                 alert("Passwords do not match.");
//$('#error_message').html('<div class="alert alert-danger" role="alert"><strong>Passwords do not match</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); 				 
           }
		   else{
			  $('#error_message').html('');  
                $.ajax({  
                     url:"forgotpwd.php",  
                     method:"POST",  
                     data:{name:username, newpwd:newpwd},  
                     success:function(data){  
					 //alert(data);
					// $('#success_message').html("success");   
                       $("form").trigger("reset");  
					  // $('#success_message').html(data); 
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
 <script> 	
 $(document).ready(function(){  
      $('#close').click(function(){
		   $("form").trigger("reset");
		
		  });
		});  
 </script> 		
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>


</html>