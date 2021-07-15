
<?php	  
	 require('db.php');
   if (isset($_POST["username"])) {
		$username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $newpwd = stripslashes($_REQUEST['newpwd']);
        $newpwd = mysqli_real_escape_string($con, $newpwd);
	    $query =    "SELECT * FROM `admin` WHERE `ad-user` = '".$username."' " ;     
	    $result= mysqli_query($con, $query);
	  	if(mysqli_num_rows($result)>0){
	    $query  =	"UPDATE `admin` SET `ad-pwd` = '" . md5($newpwd) . "'  WHERE `ad-user` = '$username'";
		$result   = mysqli_query($con, $query)or die(mysql_error());
	
			
			echo "<div class='alert alert-success' role='alert'> <strong>successfully Created</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";  
		}else{
			
			echo "<div class='alert alert-danger' role='alert'> <strong>User does not exist</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		}
		
   }
		
	?>
 