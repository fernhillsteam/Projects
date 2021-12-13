<?php 
session_start();
include_once 'db_connect.php';
	if(isset($_POST['save']))
{	 
	 $title = $_POST['title'];
	 $description = $_POST['description'];
	 $sdate = $_POST['sdate'];
	 $edate = $_POST['edate'];
	 $cdate = $_POST['cdate'];
	 $sql = "INSERT INTO events1 (title,description,start_date,end_date,created)
	 VALUES ('$title','$description','$sdate','$edate','$cdate')";
	 echo $sql;
	 if (mysqli_query($conn, $sql)) {
		/*echo "New record created successfully !";*/
		$_SESSION['status'] = "data inserted Successfully";
		header('location:eventmanage.php');
         

	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
}
 ?>