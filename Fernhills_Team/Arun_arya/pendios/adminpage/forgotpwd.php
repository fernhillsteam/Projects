
<?php	  
	 require('db.php');
   if (isset($_POST["username"])) {
		$username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $newpwd = stripslashes($_REQUEST['newpwd']);
        $newpwd = mysqli_real_escape_string($con, $newpwd);
	
	    $query  =	"update `usersp` set `password` = '" . md5($newpwd) . "'  where `username` = '$username'";
		$result   = mysqli_query($con, $query);
		if($result>0){
			
			echo "<script>alert('your password has been reset successfully');</script>";  
		}else{
			
			echo "<script>alert('incorrect username');</script>";
		}
		
   }
		
	?>
 