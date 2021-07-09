
		<?php
        require('db.php');

		
		// Check connection
		if($con === false){
			die("ERROR: Could not connect. "
				. mysqli_connect_error());
		}
		
		// Taking all 5 values from the form data(input)
		$user_id = $_REQUEST['user_id'];
		$device = $_REQUEST['device'];
		$mobile = $_REQUEST['mobile'];
		$auth = $_REQUEST['auth'];
		$link = $_REQUEST['server'];
		$apn = $_REQUEST['apn'];
		$username = $_REQUEST['user'];
		$password = $_REQUEST['pwd'];
		$location = $_REQUEST['location'];
		$address = $_REQUEST['address'];
		
		// Performing insert query execution
	
		$query = "UPDATE `configuration` SET  `device_id`= '".$device."',`mobile_number`='".$mobile."',`auth_code`= '".$auth."',`server_link`='".$link."',
		`apn`='".$apn."',`username`='".$username."',`password`='".$password."',`location`='".$location."',`address`='".$address."' WHERE `user_id`='".$user_id."'";
			//"update `actions` set `button1` = 0 where `id` = '".$id."'";
	    $result   = mysqli_query($con, $query);
		if($result>0){
			
			echo "<div class='alert alert-success' role='alert'>successfully Updated</div>";  
		}else{
			
			echo "Try Again";
		}
		
		// Close connection
		mysqli_close($con);
	
?>