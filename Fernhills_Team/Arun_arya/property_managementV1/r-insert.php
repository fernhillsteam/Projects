<?php

    // Insert the content of connection.php file
    include('connect.php');
    
    // Insert data into the database
    if(isset($_POST['sub'])){
    $t=$_POST['text'];
    $l=$_POST['location'];
    $b=$_POST['beds'];
    $b1=$_POST['bathrooms'];
    $park=$_POST['park'];
    $a=$_POST['area'];
    $rprice=$_POST['rprice'];
    $sdeposit=$_POST['sdeposit'];

    //code for image uploading
    if($_FILES['f1']['name']){
        move_uploaded_file($_FILES['f1']['tmp_name'], "rent/".$_FILES['f1']['name']);
        $img="rent/".$_FILES['f1']['name'];
	}
	
    $i="insert into rent(name,location,beds,bathrooms,image,parking,area,rprice,sdeposit)values('$t','$l','$b','$b1','$img','$park','$a','$rprice','$sdeposit')";     
        $result = mysqli_query($con, $i);

        if($result){
            echo '<script> alert("Data saved."); </script>';
            //header('Location: index.php');
			echo '<script>window.location = "rent.php";</script>';
			
        }else{
            echo '<script> alert("Data Not saved."); </script>';
        }
	  
    }
?>