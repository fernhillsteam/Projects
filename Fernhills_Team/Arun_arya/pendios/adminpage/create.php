<?php
require "db.php";

//if(isset($_POST['table_name'])){
    

//$table_name=mysqli_real_escape_string($con,$_POST['table_name']);

//$result = mysqli_query($con,"SHOW TABLES LIKE '".$table_name."'");
//if($result->num_rows == 1) {

  //      echo '<script language="javascript">';
    //    echo 'alert("Table exists, Please try again")';
      //  echo '</script>';
//}
//else {
  
  //  $table5 = "CREATE TABLE $table_name ( id INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,device_id VARCHAR(200),username VARCHAR(200), mobilenumber VARCHAR(200),email VARCHAR(200) ,password VARCHAR(200) ,date datetime)";

    //*$query = "INSERT INTO $table_name (`id`, `emp_name`, `salary`, `status`, `date`) VALUES ('$id','$emp_name','$salary','$status','$date')";*/

    //$res5=mysqli_query($con,$table5);

 //       echo '<script language="javascript">';
   //     echo 'alert("Table Successfully Created")';
     //   echo '</script>';


//}
//}
if (isset($_POST['device_id'])) {
    $device_id=$_POST['device_id'];
    $username=$_POST['user'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
    $password=$_POST['pwd'];
    $date=$_POST['date'];
	$query =    "SELECT * FROM `usersp` WHERE `mobilenumber` = '".$mobile."' " ;     
	    $result= mysqli_query($con, $query);
	  	if(mysqli_num_rows($result)>0){
			
             		echo "<div class='alert alert-primary' role='alert'><strong>Already user exists </strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		}else{
			
			$query = "INSERT INTO `usersp` ( `username`,`device_id`, `mobilenumber`,`email`,`password`, `create_datetime`) VALUES ('$username','$device_id','$mobile','$email','" . md5($password) . "','$date')";
            $result=mysqli_query($con,$query);

			
			echo "<div class='alert alert-success' role='alert'> <strong>successfully Created</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  
	
		}
		
		// Close connection
		mysqli_close($con);

 } 


?>
