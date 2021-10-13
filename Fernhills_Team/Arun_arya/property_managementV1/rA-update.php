<?php

    // Insert the content of connection.php file
    include('connect.php');

    // Update data into the database
    if(ISSET($_POST['updateData']))
    {   
        $id = $_POST['updateId'];
        $text = $_POST['updatetext'];
        $location = $_POST['updatelocation'];
        $beds = $_POST['updatebeds'];
        $bathrooms = $_POST['updatebathrooms'];
        $park = $_POST['updatepark'];
        $area = $_POST['updatearea'];
        $price = $_POST['updaterprice'];
		$deposit = $_POST['updatesdeposit'];
        /*$f1 = $_POST['updatef1'];*/

        //code for image uploading
        if($_FILES['updatef1']['name']){
        move_uploaded_file($_FILES['updatef1']['tmp_name'], "image/".$_FILES['updatef1']['name']);
        $img="image/".$_FILES['updatef1']['name'];

        $sql = "UPDATE rent SET name='$text',
                                        location='$location', 
                                        beds='$beds',
                                        bathrooms=' $bathrooms',
                                        image = '$img',
                                        parking = '$park',
                                        area = '$area',
                                        rprice = '$price',
										sdeposit = '$deposit'
                                        WHERE id='$id'";

        $result = mysqli_query($con, $sql);

        if($result)
        {
            echo '<script> alert("Data Updated Successfully."); </script>';
            //header("Location:rentA.php");
			echo '<script>window.location = "rentA.php";</script>';
        }
        else
        {
            echo '<script> alert("Data Not Updated"); </script>';
        }
    }
	
	}
?>