<?php

   require('db.php');

 
  $colname = $_POST['btn'];
  $id=$_POST['id'];

  if($colname == "btn1"){
	  
  $query = "update `actions` set `button1` = 0 where `id` = '".$id."'";
  $result   = mysqli_query($con, $query);
}
if($colname == "btn2"){
	 $query ="update `actions` set `button2` = 0 where `id` = '".$id."'";
     $result   = mysqli_query($con, $query);
	
}

if($colname == "btn3"){
	 $query ="update `actions` set `button3` = 0 where `id` = '".$id."'";
  $result   = mysqli_query($con, $query);

}
if($colname == "btn4"){
   $query = "update `actions` set `button4` = 0 where `id` = '".$id."'";
   $result   = mysqli_query($con, $query);


}


			 
?>
