<!-- <?php
session_start();
$con= mysqli_connect("localhost","root","","madhunivas")
?> -->
<?php

$db = mysqli_connect("localhost","root","","madhunivas");  // database connection

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>