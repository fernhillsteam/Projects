 <?php

 include('connection.php');


 $result = mysqli_connect($host,$uname,$pwd) or die("Could not connect to database." .mysqli_error());
  mysqli_select_db($result,$db_name) or die("Could not select the databse." .mysqli_error());

  $query = mysqli_query($result,"SELECT Short_circuit,Shutdown,Overload,Tampering,Health from indicator") or die("Could not find table".mysqli_error());
while ($arr = mysqli_fetch_array($query)) {
  $sc = $arr['Short_circuit'];
  $sd = $arr['Shutdown'];
   $ov = $arr['Overload'];
    $tamp = $arr['Tampering'];
     $hl = $arr['Health'];
   }

   $myArr = [$sc,$sd,$ov,$tamp,$hl];
   $myJSON = json_encode($myArr);
   echo $myJSON;
  ?>