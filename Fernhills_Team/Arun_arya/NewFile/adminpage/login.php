<?php

    session_start();
	 require('db.php');
    // When form submitted, check and create user session.

    if (isset($_POST['usera'])) {
               $username=$_POST['usera'];
               $password=$_POST['pwda'];
    
        // Check user is exist in the database
        $query    = "SELECT * FROM `admin` WHERE `ad-user` = '$username' AND `ad-pwd`='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows==1) {
			//$row=mysql_fetch_array($select_data)
          $_SESSION['username'] = $username;
     
          echo "success";

        } else {
            
			echo "fail";
		}
    }
?>