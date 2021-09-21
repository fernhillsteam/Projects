<?php
include('auth_session.php');


require('db.php');

if(isset($_FILES['profileImage']['name'])){
    
	$profileImageName =$_FILES['profileImage']['name'];
	
	// get the image extension
 
   $extension= pathinfo($profileImageName, PATHINFO_EXTENSION);

	// allowed extensions
    $allowed_extensions = array("jpg","jpeg","png","gif");
	
    if(in_array($extension,$allowed_extensions))
     {
		//rename the image file
		$imgnewfile=md5($profileImageName).$extension;
		$target='../profileimage/'. $imgnewfile;
		// Code for move image into directory
		move_uploaded_file($_FILES['profileImage']['tmp_name'],$target);
		// Query for insertion data into database
		$query = "UPDATE `usersp` SET  `image`='".$imgnewfile."' WHERE `mobilenumber`='".$_SESSION['mobilenumber']."'";
        $result = mysqli_query($con,$query);
		
        if($result){
			
			echo $target;	
			
		}else{
			
			echo "fail";
		}
				
		
		}else{
			
				echo "invalid";	 
		}
	
	   
   exit;
}
?>
