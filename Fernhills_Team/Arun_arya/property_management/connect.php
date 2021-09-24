<!-- <?php
session_start();
$con= mysqli_connect("localhost","root","root@123","madhunivas")
?> -->
<?php

$db = mysqli_connect("localhost","root","root@123","madhunivas");  // database connection

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>