<?php
 require('db.php');
  
   
    // When form submitted, insert values into the database.
    if (isset($_POST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
		
	    $device_id    = stripslashes($_REQUEST['device_id']);
        $device_id   = mysqli_real_escape_string($con, $device_id);

		$mobilenumber    = stripslashes($_REQUEST['mobilenumber']);
        $mobilenumber    = mysqli_real_escape_string($con, $mobilenumber);

        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
		
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
		
        $create_datetime =$_REQUEST['date'];
        $query    = "INSERT into `usersp` ( username, device_id , mobilenumber, email, password, create_datetime)
                     VALUES ('$username', '$device_id','$mobilenumber' ,'$email', '" . md5($password) . "', '$create_datetime')";
        $result   = mysqli_query($con, $query);

        if ($result) {
            echo  "your password has been rest successfully";  
        } else {
			
            echo "try again ";
        }
    }
?>

Warning: Undefined array key "device_id" in C:\xampp\htdocs\pendios\adminpage\create.php on line 12

Fatal error: Uncaught Error: Undefined constant "date" in C:\xampp\htdocs\pendios\adminpage\create.php:24 Stack trace: #0 {main} thrown in C:\xampp\htdocs\pendios\adminpage\create.php on line 24
© 