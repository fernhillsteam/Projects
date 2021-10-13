<!DOCTYPE html>
<html>
<head>
  <title>Rent property list</title>
<body>

<h2>Rent property list</h2>

<table border="2">
  <tr>
    <td>Image</td>
    <td>Name</td>
    <td>Location/address</td>
    <td>No of bedrooms</td>
    <td>No of bathrooms</td>
    <td>Parking</td>
    <td>plot area</td>
    <td>price</td>
    <td>amount</td>
  </tr>

<?php

include "connect.php"; // Using database connection file here

$records = mysqli_query($db,"select * from rent"); // fetch data from database

while($data = mysqli_fetch_array($records))
{
?>
  <tr>
  	<td><img src="<?php echo $data['image']; ?>" width="100" height="100"></td>
    <td><?php echo $data['name']; ?></td>
    <td><?php echo $data['location']; ?></td>
    <td><?php echo $data['beds']; ?></td>
    <td><?php echo $data['bathrooms']; ?></td>    
    <td><?php echo $data['parking']; ?></td>
    <td><?php echo $data['area']; ?></td>
    <td><?php echo $data['price']; ?></td>
    <td><?php echo $data['amount']; ?></td>
  </tr>	
<?php
}
?>

</table>

<?php mysqli_close($db);  // close connection ?>
<a href="register.php">Add Property</a><br>
<a href="rent.php">Add Rent Property</a><br>
<!-- <a href="login1.php">login</a><br>
<a href="logout.php">logout.php</a> -->
</body>
</html>