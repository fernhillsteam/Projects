<?php
include('connection.php');


$result = mysqli_connect($host,$uname,$pwd) or die("Could not connect to database." .mysqli_error());
  mysqli_select_db($result,$db_name) or die("Could not select the databse." .mysqli_error());

   $query = mysqli_query($result,"SELECT button1,button2,button3,button4,button5 from actions where id=1 ") or die("Could not find table".mysqli_error());

   while ($arr = mysqli_fetch_array($query)) {
  $btn1 = $arr['button1'];
  $btn2 = $arr['button2'];
   $btn3 = $arr['button3'];
    $btn4 = $arr['button4'];
     $btn5 = $arr['button5'];
   }

   $myArr = [$btn1,$btn2,$btn3,$btn4,$btn5];
   $myJSON = json_encode($myArr);
   echo $myJSON;

?>

