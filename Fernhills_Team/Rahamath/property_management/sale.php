<!DOCTYPE html>
<html lang="en">

<head>
	<title>GFG- Store Data</title>
</head>

<body>
	<center>
		<h1>Storing Form data in Database</h1>

		<form action="insert.php" method="post">
			
			
<p>
				<label for="images">image:</label>
				<input type="file" name="images" value="" id="images" />
			</p>



			
			
<p>
				<label for="name">Name:</label>
				<input type="text" name="name" id="name">
			</p>



			
			
<p>
				<label for="location">location:</label>
				<input type="text" name="location" id="location">
			</p>


			
			
			
<p>
				<label for="beds">beds:</label>
				<input type="number" name="beds" id="beds">
			</p>


			
			
			
<p>
				<label for="bathrooms">bathrooms:</label>
				<input type="number" name="bathrooms" id="bathrooms">
			</p>

			<p>
				<label for="garden">garden:</label>
				<input type="number" name="garden" id="garden">
			</p>

			<p>
				<label for="area">plot area:</label>
				<input type="text" name="area" id="area">
			</p>

            
            <p>
				<label for="price">&#8377;:</label>
				<input type="text" name="price" id="price">
			</p>

			
			<input type="submit" value="Submit">
		</form>
	</center>
</body>

</html>
