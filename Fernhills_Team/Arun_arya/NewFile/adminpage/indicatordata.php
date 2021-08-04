<?php
$id = $_GET["a"];
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
   require('db.php');
$query ="SELECT * FROM `indicator` WHERE `device_id` = '".$id."' ";
			        
 $result = mysqli_query($con, $query) or die(mysql_error());

	                       while($row = mysqli_fetch_array($result)){
							    $short  =$row[2];
					            $shutdown=$row[3];
					            $overload=$row[4];
					            $tamper=$row[5];
				            	$health=$row[6];							
							   
						 $value = [ $short,$shutdown, $overload,$tamper,$health];
					
			             $valueJSON=json_encode($value);   
					
						echo "data: {$valueJSON}\n";
		                echo "id: {$id}\n";
					  }

flush();
?>

