<?php
 include('connection.php');

 $result = mysqli_connect($host,$uname,$pwd) or die("Could not connect to database." .mysqli_error());
  mysqli_select_db($result,$db_name) or die("Could not select the databse." .mysqli_error());

  $colname = $_POST['colname'];
  if($colname == "btn1"){
  $query = mysqli_query($result,"update actions set button1=1 where id=1") or die("Could not find table".mysqli_error($result));
}
if($colname == "btn2"){
	 $query = mysqli_query($result,"update actions set button2=1 where id=1") or die("Could not find table".mysqli_error($result));
}

if($colname == "btn3"){
$query = mysqli_query($result,"update actions set button3=1 where id=1") or die("Could not find table".mysqli_error($result));

}
if($colname == "btn4"){
$query = mysqli_query($result,"update actions set button4=1 where id=1") or die("Could not find table".mysqli_error($result));

}
if($colname == "btn5"){
$query = mysqli_query($result,"update actions set button5=1 where id=1") or die("Could not find table".mysqli_error($result));

}
?>