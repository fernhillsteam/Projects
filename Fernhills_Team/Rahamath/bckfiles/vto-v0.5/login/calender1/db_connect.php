<?php
/* Database connection start */

// Username is root
 $username = 'u152216168_vto';
//$user = 'root';
 $password = 'Vto@1234567890'; 
//$password = 'root@123'; 
  
// Database name is gfg
$dbname = 'u152216168_vto'; 
  
// Server is localhost with
// port number 3308
$servername='localhost';
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>