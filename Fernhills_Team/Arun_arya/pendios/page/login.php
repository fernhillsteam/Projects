<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
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
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['submit1'])) {
        $mobilenumber = stripslashes($_REQUEST['mobilenumber']);    // removes backslashes
        $mobilenumber = mysqli_real_escape_string($con, $mobilenumber);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE mobilenumber ='$mobilenumber'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
          $_SESSION['mobilenumber'] = $mobilenumber;
          //Redirect to user dashboard page
            header("Location: dashboard.php");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {

?>
    <form class="form" method="post" name="login">
 
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="mobilenumber" placeholder="Mobile Number" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
		 
        <input type="submit" value="Login" name="submit1" class="login-button"/><br></br>
		<a href="#" data-target="#pwdModal" data-toggle="modal">Forgot password ?</a>
  </form>
 
 


<?php
	}
  
   // When form submitted, check and create user session.
   if (isset($_POST['submit2'])) {
		$mobilenumber = stripslashes($_REQUEST['mobilenumber']);    // removes backslashes
        $mobilenumber = mysqli_real_escape_string($con, $mobilenumber);
        $newpwd = stripslashes($_REQUEST['newpwd']);
        $newpwd = mysqli_real_escape_string($con, $newpwd);
	  
	    $query  =	"update `users` set `password` = '" . md5($newpwd) . "'  where `mobilenumber` = '$mobilenumber'";
		$result   = mysqli_query($con, $query);

	
	}

?>
	<!-- forgot password--->
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
                        <div class="text-center">
                          
                          <p>If you have forgotten your password you can reset it here.</p>
                            <div class="panel-body">
							   <form action="" method="post">
                                <fieldset>
								    <div class="form-group">
                                       <input class="form-control input-lg" placeholder="mobilenumber" name="mobilenumber" type="text">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control input-lg"  id ="newPwd" placeholder="New Password" name="newpwd" type="password">
                                    </div>
									<div class="form-group">
                                        <input class="form-control input-lg"   id ="confirmPwd" placeholder="Confirm password" name="confirmpwd" type="password">
                                    </div>
                                    <input class="btn  btn-primary btn-block" id= "btnSubmit" value=" Reset Password" type="submit" name="submit2">
                                </fieldset>
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
</script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
 
    
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
 <script src="bootstrap-4.0.0/dist/js/bootstrap.js"></script>
 <script src="../assets/js/core/bootstrap.min.js"></script>
</body>
</html>