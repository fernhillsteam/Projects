
		<?php
        require('db.php');

	
		// Taking all 5 values from the form data(input)
	if (isset($_POST['device'])) {	
		$device = $_POST['device'];
		$mobile = $_POST['mobile'];
		$auth = $_POST['auth'];
		$link = $_POST['server'];
		$apn = $_POST['apn'];
		$username = $_POST['user'];
		$password = $_POST['pwd'];
		$location = $_POST['location'];
		$address = $_POST['address'];
		
		// Performing insert query execution
	
		$query = "UPDATE `configuration` SET  `mobile_number`='".$mobile."',`auth_code`= '".$auth."',`server_link`='".$link."',
		`apn`='".$apn."',`username`='".$username."',`password`='".$password."',`location`='".$location."',`address`='".$address."' WHERE `device_id`= '".$device."'";
			
	    $result   = mysqli_query($con, $query);
		if($result>0){
					
			echo "<div class='alert alert-success' role='alert'> <strong>successfully Updated</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		}else{
			
			echo "Try Again";
		}
	}
		// Close connection
		mysqli_close($con);
	
?>