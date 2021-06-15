<?php
$host = "localhost";
$user = "u949021360_Pendios";
$pass = "Pendios@123";
$db = "u949021360_Pendios";

$con = mysqli_connect($host,$user,$pass,$db);

$sql = "SELECT * FROM configuration";
$result = mysqli_query($con, $sql);
$resultCheck = mysqli_num_rows($result);
$json_response = array();
if ($resultCheck > 0){
    while ($row = mysqli_fetch_assoc($result)) {
    //echo "<h1>";
/*     echo "{";
    echo $row['device_id'];
	echo ',';
    echo $row['mobile_number'];
	echo ',';
    echo $row['auth_code'];
	echo ',';
	echo $row['server_link'];
	echo ',';
    echo $row['apn'];
	echo ',';
    echo $row['username'];
	echo ',';
	echo $row['password'];
	echo ',';
    echo $row['location'];
	echo ',';
    echo $row['address'];
    echo "}"; */
    //echo "</h1>";
$row_array['device'] = $row['device_id']; 
$row_array['mobile'] = $row['mobile_number']; 
$row_array['auth'] = $row['auth_code']; 
$row_array['server'] = $row['server_link']; 
$row_array['apn'] = $row['apn']; 
$row_array['username'] = $row['username']; 
$row_array['password'] = $row['password']; 
$row_array['location'] = $row['location']; 
$row_array['address'] = $row['address']; 	
//push the values in the array  
array_push($json_response,$row_array); 
}
}
echo json_encode($json_response);
?>
