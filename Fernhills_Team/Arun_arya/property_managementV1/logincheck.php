<?php
    session_start();
    include_once "connect.php";
    // When form submitted, check and create user session.

    if (isset($_POST['email'])) {
               $email = $_POST['email'];
               $password = $_POST['pwd'];
			   
        // Check user is exist in the database
        $query    = "SELECT * FROM `admin_login` WHERE `email` ='$email' AND password='$password'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows==1) {
			
			$_SESSION['email'] = $email;
            echo "success";

        } else if($rows==0) {
			
			$query    = "SELECT * FROM `user_login` WHERE `email` ='$email' AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows==1) {
			
			$_SESSION['email'] = $email;
            echo "success";

        } else{
            
			echo "fail";
		}
		}
    }
?>