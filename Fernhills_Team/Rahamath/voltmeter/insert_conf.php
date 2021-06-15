<!DOCTYPE html>
<html>

<head>
	<title>Insert Page page</title>
</head>

<body>
	<center>
		<?php

		 $host = "localhost";
         $user = "u949021360_Pendios";
         $pass = "Pendios@123";
         $db = "u949021360_Pendios";
		$con = mysqli_connect($host,$user,$pass,$db);
		
		// Check connection
		if($con === false){
			die("ERROR: Could not connect. "
				. mysqli_connect_error());
		}
		
		// Taking all 5 values from the form data(input)
		$device = $_REQUEST['device'];
		$mobile = $_REQUEST['mobile'];
		$auth = $_REQUEST['auth'];
		$link = $_REQUEST['link'];
		$apn = $_REQUEST['apn'];
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$location = $_REQUEST['location'];
		$address = $_REQUEST['address'];
		
		// Performing insert query execution
		// here our table name is college
		$sql = "INSERT INTO configuration (device_id,mobile_number,auth_code,server_link,apn,username,password,location,address) VALUES ('$device',
			'$mobile','$auth','$link','$apn','$username','$password','$location','$address')";
		
		if(mysqli_query($con, $sql)){
			echo "<h3>data stored in a database successfully."
				. " Please browse your localhost php my admin"
				. " to view the updated data</h3>";

			echo nl2br("$device\n
			$mobile\n$auth\n$link\n$apn\n$username\n$password\n$location\n$address");
		} else{
			echo "ERROR: Hush! Sorry $sql. "
				. mysqli_error($con);
		}
		
		// Close connection
		mysqli_close($conn);
		?>
	</center>
</body>

</html>
