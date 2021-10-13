<?php
include 'connect.php';
 
if(isset($_POST['sub'])){
	$t=$_POST['text'];
	$l=$_POST['location'];
	$b=$_POST['beds'];
	$b1=$_POST['bathrooms'];
	$park=$_POST['park'];
	$a=$_POST['area'];
	$price=$_POST['price'];
 
	//code for image uploading
	if($_FILES['f1']['name']){
		move_uploaded_file($_FILES['f1']['tmp_name'], "image/".$_FILES['f1']['name']);
		$img="image/".$_FILES['f1']['name'];
	}
 
	$i="insert into register(image,name,location,beds,bathrooms,parking,area,price)values('$img','$t','$l','$b','$b1','$park','$a','$price')";
		if(mysqli_query($con, $i)){
		echo "inserted successfully..!";
	}
}
?>
<html>
	<head>
	<meta charset="UTF-8">
	<title></title>
	</head>
	<body>
		<h2>Add Property</h2>
		<form method="POST" enctype="multipart/form-data" >
			<table>
				<tr>
					<td>
						Name
						<input type="text" name="text">
					</td>
				</tr>
				<tr>
					<td>
						location
						<input type="text" name="location">
					</td>
				</tr>
				<tr>
					<td>
						Numbers of bedrooms
						<input type="radio"name="beds" id="beds" value="1">1
						<input type="radio" name="beds" id="beds" value="2">2
						<input type="radio" name="beds" id="beds" value="3">3
						<input type="radio" name="beds" id="beds" value="4">4
					</td>
				</tr>
				<tr>
					<td>
						Numbers of bathrooms
						<input type="radio"name="bathrooms" id="bathrooms" value="1">1
						<input type="radio" name="bathrooms" id="bathrooms" value="2">2
						<input type="radio" name="bathrooms" id="bathrooms" value="3">3
						<input type="radio" name="bathrooms" id="bathrooms" value="4">4
					</td>
				</tr>
				<tr>
					<td>
						Parking
						<input type="text"name="park" id="park" >
					</td>
				</tr>
				<tr>
					<td>
						plot area
						<input type="text" name="area">
					</td>
				</tr>
				<tr>
					<td>
					price
						<input type="text" name="price">
					</td>
				</tr>
				
				<tr>
					<td>
						Image
						<input type="file" name="f1">
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="submit" name="sub">
					</td>
				</tr>
			</table>
		</form>
		<a href="home.php">property list</a>
	</body>
</html>
 