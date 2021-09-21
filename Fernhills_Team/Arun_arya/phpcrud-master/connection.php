<?php

$servername="localhost";
$username="root";
$password="root@123";
$dbname="madhunivas";

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if(!$con){
  die("Connection failed: ".mysqli_connect_error());
}

//echo "Connected successfully";

?>