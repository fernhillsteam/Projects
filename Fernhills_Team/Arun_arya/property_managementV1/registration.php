<?php
include_once "connect.php";

if (isset($_POST['name'])) {
    $name=$_POST['name'];
    $owner=$_POST['ownerty'];
	$email=$_POST['email'];
    $password=$_POST['pwd'];

	
	
	    $query = "INSERT INTO `user_login` ( `name`,`ownertype`,`email`,`password`) VALUES ('$name','$owner','$email','" . md5($password) . "')";
	    $result= mysqli_query($con, $query);
	  	
		echo "success";	
	
		}else{
		
		echo "fail";	
		
		
		}
		
		// Close connection
		mysqli_close($con);




?>