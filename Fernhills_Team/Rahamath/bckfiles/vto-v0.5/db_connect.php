<?php
// Username is root
//$user = 'u152216168_vto';
$user = 'root';
//$password = 'Vto@1234567890'; 
$password = ''; 
  
// Database name is gfg
$database = 'vvto'; 
  
// Server is localhost with
// port number 3308
$servername='localhost';
$mysqli = new mysqli($servername, $user, 
                $password, $database);
  
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' . 
    $mysqli->connect_errno . ') '. 
    $mysqli->connect_error);
}
?>