
<?php

$con = mysqli_connect("localhost","root","root@123","madhunivas");  // database connection

if(!$con)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>