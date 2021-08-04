<?php
$id = $_GET["b"];
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
   require('db.php');
 $query =    "SELECT * FROM `actions` WHERE `device_id` = '".$id."'";
			        
                           $result = mysqli_query($con, $query) or die(mysql_error());

	                       while($row = mysqli_fetch_array($result)){
							$btn1 = $row['button1'];
                            $btn2 = $row['button2'];
                            $btn3 = $row['button3'];
                            $btn4 = $row['button4'];							
							   
						 $value = [ $btn1,$btn2,$btn3,$btn4];
					
			             $valueJSON=json_encode($value);   
					
						echo "data: {$valueJSON}\n";
		                echo "id: {$id}\n";
						
					  }

flush();
?>

