<?php

   require('db.php');

 
  $colname = $_POST['btn'];
  $id=$_POST['id'];

  if($colname == "1"){
	  
  $query = "update `actions` set `button1` = 0 where `id` = '".$id."'";
  $result   = mysqli_query($con, $query);
}
if($colname == "2"){
	 $query ="update `actions` set `button2` = 0 where `id` = '".$id."'";
     $result   = mysqli_query($con, $query);
	
}

if($colname == "3"){
	 $query ="update `actions` set `button3` = 0 where `id` = '".$id."'";
  $result   = mysqli_query($con, $query);

}
if($colname == "4"){
   $query = "update `actions` set `button4` = 0 where `id` = '".$id."'";
   $result   = mysqli_query($con, $query);


}


			 
?>
