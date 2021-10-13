
<?php	  
	 require('connect.php');
	 
   if (isset($_POST["name"])) {
		$username = $_POST["name"];
        $newpwd = $_POST["newpwd"];
       
	    $query =    "SELECT * FROM `user_login` WHERE `name` = '".$username."' " ;     
	    $result= mysqli_query($con, $query);
	  	if(mysqli_num_rows($result)>0){
	    $query  =	"update `user_login` set `password` = '" . md5($newpwd) . "'  where `name` = '$username'";
		$result   = mysqli_query($con, $query)or die(mysql_error());
			
			echo "successfully Created"; 
		}else if(mysqli_num_rows($result)==0){
		
		                     $query =    "SELECT * FROM `admin_login` WHERE `name` = '".$username."' " ;     
	                         $result= mysqli_query($con, $query);
	  	if(mysqli_num_rows($result)>0){
	                $query  =	"update `admin_login` set `password` = '" . md5($newpwd) . "'  where `name` = '$username'";
		            $result   = mysqli_query($con, $query)or die(mysql_error());
			
			echo "successfully Created"; 
		}
		      }else{
			
				echo "<div class='alert alert-danger' role='alert'> <strong>User does not exist</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		      }
		
		
   }
		
	?>
 