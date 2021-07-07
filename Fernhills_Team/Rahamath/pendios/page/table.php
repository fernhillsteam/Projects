<?php
include "db.php";

if(isset($_POST['submit'])){
    

$table_name=mysqli_real_escape_string($con,$_POST['table_name']);

$result = mysqli_query($con,"SHOW TABLES LIKE '".$table_name."'");
if($result->num_rows == 1) {

        echo '<script language="javascript">';
        echo 'alert("Table exists, Please try again")';
        echo '</script>';
}
else {
  
    $table5 = "CREATE TABLE $table_name ( id INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,emp_name VARCHAR(200), salary VARCHAR(200),status tinyint(1) DEFAULT '1', date datetime)";

    /*$query = "INSERT INTO $table_name (`id`, `emp_name`, `salary`, `status`, `date`) VALUES ('$id','$emp_name','$salary','$status','$date')";*/

    $res5=mysqli_query($con,$table5);

        echo '<script language="javascript">';
        echo 'alert("Table Successfully Created")';
        echo '</script>';


}
}
if (isset($_POST['submit'])) {
    $id=$_POST['id'];
    $emp_name=$_POST['emp_name'];
    $salary=$_POST['salary'];
    $status=$_POST['status'];
    $date=$_POST['date'];
$query = "INSERT INTO $table_name (`id`, `emp_name`, `salary`, `status`, `date`) VALUES ('$id','$emp_name','$salary','$status','$date')";
$result=mysqli_query($con,$query);

 } 


?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Automatic Table in php mysqli by Yourphpguru</title>
</head>
<body>
    <center>
    <form action="" method="post" style="margin-top: 50px;margin-left: 70px;">
        <input type="text" name="table_name"><br/>
        <input type="text" name="id" placeholder="id"><br/>
        <input type="text" name="emp_name" placeholder="emp"><br/>
        <input type="text" name="salary" placeholder="salary"><br/>
        <input type="text" name="status" placeholder="status"><br/>
        <input type="text" name="date" placeholder="date"><br/>
        <input type="submit" name="submit" value="submit">
    </form>
    </center>
</body>
</html>

