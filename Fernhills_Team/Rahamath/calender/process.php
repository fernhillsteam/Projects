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
	 $stime = $_POST['stime'];
	 $etime = $_POST['etime'];
	 $efee = $_POST['efee'];
	 $sql = "INSERT INTO events1 (title,description,start_date,end_date,created,stime,etime,efee)
	 VALUES ('$title','$description','$sdate','$edate','$cdate','$stime','$etime','$efee')";
	 echo $sql;
	 if (mysqli_query($conn, $sql)) {
		/*echo "New record created successfully !";*/
		$_SESSION['status'] = "data inserted Successfully";
		header('location:index.php');
         

	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
}
 ?>