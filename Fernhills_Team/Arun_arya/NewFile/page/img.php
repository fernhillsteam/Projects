
<?php


require "db.php";



if(isset($_POST['file'])){
	$file=$_FILES['file'];
	$fileName=$file['name'];
	$fileTmpName=$file['tmp_name'];
	$fileSize=$file['size'];
	$fileError=$file['error'];
	$fileType=$file['type'];
	
	$fileExt = explode('.',$fileName);
	$fileActualExt=strtolower(end($fileExt));
	
	$allowed=array('jpg','jpeg','png','pdf');
//	$id=$_POST['id'];
	if(in_array($fileActualExt,$allowed)){
		if($fileError===0){
			if($fileSize<1000000){
				$fileNameNew = "profile3169.".$fileActualExt;
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($fileTmpName,$fileDestination);
				$sql="UPDATE userimg SET satatus=0 WHERE device_id='3169'";
			}else{
				echo "your file is too big";
			}
		}else{
				echo "there was error uploading";
			}
	}else{
				echo "you cannot upload files";
			}
}

?>