
<?php	  
	 require('db.php');
   if (isset($_POST["username"])) {
		$username = $_POST["username"];
        $newpwd = $_POST["newpwd"];
       
	    $query =    "SELECT * FROM `usersp` WHERE `username` = '".$username."' " ;     
	    $result= mysqli_query($con, $query);
	  	if(mysqli_num_rows($result)>0){
	    $query  =	"update `usersp` set `password` = '" . md5($newpwd) . "'  where `username` = '$username'";
		$result   = mysqli_query($con, $query)or die(mysql_error());
			
			echo "<div class='alert alert-success' role='alert'> <strong>successfully Created</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>"; 
		}else{
			
				echo "<div class='alert alert-danger' role='alert'> <strong>User does not exist</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		}
		
		
   }
		
	?>
 