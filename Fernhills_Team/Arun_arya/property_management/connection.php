<?php
$hostName = "localhost"; // host name
$username = "root";  // database username
$password = "root@123"; // database password
$databaseName = "madhunivas"; // database name

$connection = new mysqli($hostName,$username,$password,$databaseName);
if (!$connection) {
    die("Error in database connection". $connection->connect_error);
}
?>