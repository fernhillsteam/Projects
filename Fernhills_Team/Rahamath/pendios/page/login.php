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
			      	<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['mobilenumber'])) {
        $mobilenumber = stripslashes($_REQUEST['mobilenumber']);    // removes backslashes
        $mobilenumber = mysqli_real_escape_string($con, $mobilenumber);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `usersp` WHERE mobilenumber ='$mobilenumber'
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
							<form  method="post" name="login" class="signin-form">
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Username</label>
			      			<input type="text" class="form-control" name="mobilenumber" placeholder="Mobile Number" autofocus="true" required>
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
		              <input type="password" class="form-control" name="password" placeholder="Password" required>
		            </div>
		            <div class="form-group">
		            	<button type="submit" value="Login" name="submit" class="form-control btn btn-primary rounded submit px-3">Log In</button>
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
		          <p class="text-center">Log In as Admin!<a href="admin.php">&nbsp;Login</a></p>
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
<?php
    }
?>
	</body>
</html>

