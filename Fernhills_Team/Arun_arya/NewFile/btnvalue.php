<?php
$id = $_GET["id"];
$btn = $_GET["btn"];

   require('db.php');
$query ="SELECT * FROM `actions` WHERE `id` = '".$id."'";
			        
 $result = mysqli_query($con, $query) or die(mysql_error());

		  
	                       while($row = mysqli_fetch_array($result)){
							   if($btn==1){
							$btn1 = $row['button1'];
							echo $btn1;
							   }
							    if($btn==2){
                            $btn2 = $row['button2'];
							echo $btn2;
							   }
							    if($btn==3){
                            $btn3 = $row['button3'];
						     echo $btn3;
						 	   }
							   if($btn==4){
                            $btn4 = $row['button4'];							
							  echo $btn4;
						 	   }
							
										
					  }

					
					
		               
					 
mysqli_close($con);

?>