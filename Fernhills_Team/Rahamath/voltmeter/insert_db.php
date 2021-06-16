<?php

$myTimeZone = date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d h:i:s A");
print $date;
 $time = $_GET['time'];
 $ac_v = $_GET['ac_v'];
 $ac_c = $_GET['ac_c'];
 $ac_p = $_GET['ac_p'];
 $dc_v = $_GET['dc_v'];
 $dc_c = $_GET['dc_c'];
 $dc_p = $_GET['dc_p'];
 


$host = "sql213.epizy.com";
$user = "epiz_27790212";
$pass = "u7iiKYniLYdpWl";
$db = "epiz_27790212_mydemo";

$con = mysqli_connect($host,$user,$pass,$db);
if($con)
	echo '</br>connected db succesfully';
	
$sql = "INSERT INTO voltameter (time_date,ac_voltage,ac_current,ac_power,dc_voltage,dc_current,dc_power) VALUES ('$time','$ac_v', '$ac_c','$ac_p','$dc_v','$dc_c','$dc_p')";

$query = mysqli_query($con,$sql);

if ($query)
	echo '</br>data inserted successfully';
else
	echo '</br>unsuccesful insertion';
?>