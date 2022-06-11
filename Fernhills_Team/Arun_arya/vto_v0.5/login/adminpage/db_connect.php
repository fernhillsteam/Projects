<?php
/* Database connection start */
$servername = "localhost";
$username = "u152216168_vto";
$password = "Vto@1234567890";
$dbname = "u152216168_vto";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>