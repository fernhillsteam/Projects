<?php

    // Insert the content of connection.php file
    include('connection.php');
    
    // Insert data into the database
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
	
    $i="insert into register(name,location,beds,bathrooms,image,parking,area,price)values('$t','$l','$b','$b1','$img','$park','$a','$price')";     
        $result = mysqli_query($con, $i);

        if($result){
            echo '<script> alert("Data saved."); </script>';
            //header('Location: index.php');
			echo '<script>window.location = "index.php";</script>';
			
        }else{
            echo '<script> alert("Data Not saved."); </script>';
        }
	  
    }
?>