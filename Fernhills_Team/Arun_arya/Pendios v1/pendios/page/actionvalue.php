   <?php
   
   include('auth_session.php');
   require('db.php');

			
   $query ="SELECT * FROM `usersp` WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
   $result = mysqli_query($con, $query) or die(mysql_error());

			 while($row = mysqli_fetch_row($result)){
   $query =    "SELECT * FROM `actions` WHERE `user_id` = '".$row[0]."' ";
			        
                           $result = mysqli_query($con, $query) or die(mysql_error());

	                       while($row = mysqli_fetch_array($result)){
							$btn1 = $row['send_sms'];
                            $btn2 = $row['update_demand'];
                            $btn3 = $row['authorize'];
                            $btn4 = $row['shutdown'];							
							   
						 $value = [ $btn1,$btn2,$btn3,$btn4];
			             $valueJSON=json_encode($value);   
						 echo  $valueJSON;
							
						   }
						   	
						   
			 }
			
			 
	
			 
			 ?>
			 
			 
		