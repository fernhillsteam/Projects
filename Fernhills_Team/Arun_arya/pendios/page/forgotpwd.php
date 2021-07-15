
<?php	  
	 require('db.php');
   if (isset($_POST["username"])) {
		$username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $newpwd = stripslashes($_REQUEST['newpwd']);
        $newpwd = mysqli_real_escape_string($con, $newpwd);
	    $query =    "SELECT * FROM `usersp` WHERE `username` = '".$username."' " ;     
	    $result= mysqli_query($con, $query);
	  	if(mysqli_num_rows($result)>0){
	    $query  =	"update `usersp` set `password` = '" . md5($newpwd) . "'  where `username` = '$username'";
		$result   = mysqli_query($con, $query)or die(mysql_error());
			
			echo "<div class='alert alert-success' role='alert'> <strong>successfully Created</strong><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>"; 
		}else{
			
			echo "<script>alert('incorrect username');</script>";
		}
		
		
   }
		
	?>
 