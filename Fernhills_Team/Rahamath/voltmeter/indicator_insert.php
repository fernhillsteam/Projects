<?php

$myTimeZone = date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d h:i:s A");
print $date;
 $Short_circuit = $_GET['sc'];
 $Shutdown = $_GET['st'];
 $Overload = $_GET['ov'];
 $Tampering = $_GET['tp'];
 //$Health = $_GET['hl'];
 

 
 if($Short_circuit === 1)
 {echo '</br>bad health';}
else
{echo '</br>good health';}



$host = "localhost";
$user = "u949021360_Pendios";
$pass = "Pendios@123";
$db = "u949021360_Pendios";

$con = mysqli_connect($host,$user,$pass,$db);
if($con)
	echo '</br>connected db succesfully';
	
$sql = "INSERT INTO indicator (Short_circuit,Shutdown,Overload,Tampering,Health) VALUES ('$Short_circuit','$Shutdown', '$Overload','$Tampering','$Health')";

$query = mysqli_query($con,$sql);

if ($query)
	echo '</br>data inserted successfully';
else
	echo '</br>unsuccesful insertion';


?>