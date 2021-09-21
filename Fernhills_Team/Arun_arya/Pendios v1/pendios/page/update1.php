<?php
   include('auth_session.php');
   require('db.php');

 
  $colname = $_POST['colname'];
  $query ="SELECT * FROM `users` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
   $result = mysqli_query($con, $query) or die(mysql_error());
  
			 while($row = mysqli_fetch_row($result)){
  if($colname == "btn1"){
  $query = mysqli_query($result,"update `actions` set `send_sms` = 1 where `user_id` = '".$row[0]."'") or die("Could not find table".mysqli_error($result));
}
if($colname == "btn2"){
	 $query = mysqli_query($result,"update `actions` set `update_demand` = 1 where `user_id` = '".$row[0]."'") or die("Could not find table".mysqli_error($result));
}

if($colname == "btn3"){
$query = mysqli_query($result,"update `actions` set `authorize` = 1 where `user_id` = '".$row[0]."'") or die("Could not find table".mysqli_error($result));

}
if($colname == "btn4"){
$query = mysqli_query($result,"update `actions` set `shutdown` = 1 where `user_id` = '".$row[0]."'") or die("Could not find table".mysqli_error($result));

}
			 }
?>