
<?php

    session_start();
	 require('db.php');
    // When form submitted, check and create user session.

    if (isset($_POST['mobilenumber'])) {
               $mobilenumber = $_POST['mobilenumber'];
               $password = $_POST['password'];
			   
        // Check user is exist in the database
        $query    = "SELECT * FROM `usersp` WHERE `mobilenumber` ='$mobilenumber' AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows==1) {
			//$row=mysql_fetch_array($select_data)
          $_SESSION['mobilenumber'] = $mobilenumber;
     
          echo "success";

        } else {
            
			echo "fail";
		}
    }
?>