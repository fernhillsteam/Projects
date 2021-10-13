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
        $price = $_POST['updateprice'];
        /*$f1 = $_POST['updatef1'];*/

        //code for image uploading
        if($_FILES['updatef1']['name']){
        move_uploaded_file($_FILES['updatef1']['tmp_name'], "image/".$_FILES['updatef1']['name']);
        $img="image/".$_FILES['updatef1']['name'];

        $sql = "UPDATE register SET name='$text',
                                        location='$location', 
                                        beds='$beds',
                                        bathrooms=' $bathrooms',
                                        image = '$img',
                                        parking = '$park',
                                        area = '$area',
                                        price = '$price'
                                        WHERE id='$id'";

        $result = mysqli_query($con, $sql);

        if($result)
        {
            echo '<script> alert("Data Updated Successfully."); </script>';
            header("Location:saleA.php");
        }
        else
        {
            echo '<script> alert("Data Not Updated"); </script>';
        }
    }
	
	}
?>