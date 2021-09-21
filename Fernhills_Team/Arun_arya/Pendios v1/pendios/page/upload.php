<?php


if(isset($_POST['save'])){
	
	$profileImageName =time() . '_' . $_FILES['profileImage']['name'];
	
	$target='uploads/'. $profileImageName;
	move_uploaded_file($_FILES['profileImage']['tmp_name'],$target);
}
?>