<!doctype html>
<html lang="en">
  <head>
  	<title>Pendios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
<?php	  
	 require('db.php');
   if (isset($_POST['submit2'])) {
		$username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $newpwd = stripslashes($_REQUEST['newpwd']);
        $newpwd = mysqli_real_escape_string($con, $newpwd);
	  
	    $query  =	"update `usersp` set `password` = '" . md5($newpwd) . "'  where `username` = '$username'";
		$result   = mysqli_query($con, $query);
		
		
	?>
   
			<!-- forgot password--->
			              <a href="#"  data-target="#pwdModal" data-toggle="modal">Forgot password ?</a>
    <div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header text-center border-0">
	 <h3 class="modal-title w-100">Reset Password</h3>
	   <h3 ></h3>

 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
				
                    <div class="panel-body">
					<?php
					            if($result){
									echo "success";
															 mysqli_close($con); 				
								}else{
									echo "fail";
								}

								?>
                     <div class="text-center">   

  
                          <p>If you have forgotten your password you can reset it here.</p>
						  </div>
                            <div class="panel-body">
							   <form action="" method="post">
                               
								    <div class="form-group">
                                       <input class="form-control input-lg" placeholder="User Name" name="username" type="text">
                                    </div>
                                    <div class="form-group">
									
                                        <input class="form-control input-lg"  id ="newPwd" placeholder="New Password" name="newpwd" type="password">
								    
									</div>
									<div class="form-group">
                                        <input class="form-control"   id ="confirmPwd" placeholder="Confirm password" name="confirmpwd" type="password">
									  <input type="checkbox" onclick="myFunction('confirmPwd', 'newPwd')" >Show Password
		                            </div>
                                    <input class="btn  btn-primary btn-block" id= "btnSubmit" value=" Reset Password" type="submit" name="submit2">
								<div class="mb-3">
                	 </form>
           </div>
                        </div>
                    
                </div>
            </div>
      </div>

  </div>
  </div>
</div>




<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
        $("#btnSubmit").click(function () {
            var newpassword = $("#newPwd").val();
            var confirmPassword = $("#confirmPwd").val();
            if (newpassword != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }else if(newpassword=="" && confirmPassword==""){
				 alert("Passwords require.");
				 return false;
			}
            return true;
        });
    });
	
         
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
<?php
}
   ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
 <script src="bootstrap-4.0.0/dist/js/bootstrap.js"></script>
 <script src="../assets/js/core/bootstrap.min.js"></script>
  </body>
</html>