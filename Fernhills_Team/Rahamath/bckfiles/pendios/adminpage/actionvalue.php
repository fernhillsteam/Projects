   <?php
   
 
   require('db.php');
   global $a;  
 $query =    "SELECT * FROM `actions` WHERE `id` =  '".$a."'";
			        
                           $result = mysqli_query($con, $query) or die(mysql_error());

	                       while($row = mysqli_fetch_array($result)){
							$btn1 = $row['button1'];
                            $btn2 = $row['button2'];
                            $btn3 = $row['button3'];
                            $btn4 = $row['button4'];							
							   
						 $value = [ $btn1,$btn2,$btn3,$btn4];
			             $valueJSON=json_encode($value);   
						echo  $valueJSON;
		
						 
						   }
						   	
	
			 ?>
			 
			 
