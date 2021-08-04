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
	$user = substr($username, 0, 2);
	$voltmeter = $user."".-$device_id."-vm";
	$faultlogs = $user."".-$device_id."-fl";
	
	$query =    "SELECT * FROM `usersp` WHERE `mobilenumber` = '".$mobile."' " ;     
	    $result= mysqli_query($con, $query);
	  	if(mysqli_num_rows($result)>0){
			
             		echo "<div class='alert alert-primary' role='alert'><strong>Already user exists </strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		}else{
			

											
						$img=0;
						
			$query = "INSERT INTO `usersp` ( `image`,`username`,`device_id`, `mobilenumber`,`email`,`password`, `create_datetime`) VALUES ('$img','$username','$device_id','$mobile','$email','" . md5($password) . "','$date')";
            $result = mysqli_query($con,$query);
			
			
            $query1 = "CREATE TABLE  `".$voltmeter."` ( sl_no INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,device_id VARCHAR(11),time_stamp VARCHAR(200), ac_v INT(20),ac_c INT(20),ac_p INT(20), dc_v INT(20),dc_c INT(20),dc_p INT(20),c_t TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP)";
			$result1 = mysqli_query($con,$query1);
			
			
			$query2 = "CREATE TABLE `".$faultlogs."` ( sl_no INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,device_id VARCHAR(11),fault_log VARCHAR(200),time DATETIME)";
			$result2 = mysqli_query($con,$query2);
			
			echo "<div class='alert alert-success' role='alert'> <strong>successfully Created</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  
	
		}
		
		// Close connection
		mysqli_close($con);

 } 


?>
<script>
var test=<?php echo $voltmeter;?>;
alert(test);
</script>