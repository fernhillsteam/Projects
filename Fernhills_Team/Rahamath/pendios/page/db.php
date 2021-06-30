<?php
  $con = mysqli_connect("localhost","root","","voltmeter");
  
  //Check Connection
  
  if(mysqli_connect_errno()){
     echo "failed to connect to Mysql:" . mysql_connect_error();
  }
?>
