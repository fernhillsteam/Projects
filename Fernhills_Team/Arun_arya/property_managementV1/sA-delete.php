<?php

    // Insert the content of connection.php file
    include('connect.php');
    
    // Delete data from the database
    if(ISSET($_POST['deleteData']))
    {
        $id = $_POST['deleteId']; 

        $sql = "DELETE FROM register WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if($result){
            echo '<script> alert("Data Deleted."); </script>';
            header('Location: saleA.php');
        }else{
            echo '<script> alert("Data Not Deleted."); </script>';
        }
    }
?>