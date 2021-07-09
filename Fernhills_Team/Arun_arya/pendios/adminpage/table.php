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
  
    $table5 = "CREATE TABLE $table_name ( device_id INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,username VARCHAR(200), mobilenummber VARCHAR(200),email VARCHAR(200) , date datetime)";

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
$query = "INSERT INTO $table_name (`device_id`, `username`, `mobilenummber`, `email`, `date`) VALUES ('$id','$emp_name','$salary','$status','$date')";
$result=mysqli_query($con,$query);

 } 


?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Automatic Table in php mysqli by Yourphpguru</title>
    <style type="text/css">
.form-style-9{
    max-width: 450px;
    background: #FAFAFA;
    padding: 30px;
    margin: 50px auto;
    box-shadow: 1px 1px 25px rgba(0, 0, 0, 0.35);
    border-radius: 10px;
    border: 6px solid #305A72;
}
.form-style-9 ul{
    padding:0;
    margin:0;
    list-style:none;
}
.form-style-9 ul li{
    display: block;
    margin-bottom: 10px;
    min-height: 35px;
}
.form-style-9 ul li  .field-style{
    box-sizing: border-box; 
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box; 
    padding: 8px;
    outline: none;
    border: 1px solid #B0CFE0;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;

}.form-style-9 ul li  .field-style:focus{
    box-shadow: 0 0 5px #B0CFE0;
    border:1px solid #B0CFE0;
}
.form-style-9 ul li .field-split{
    width: 49%;
}
.form-style-9 ul li .field-full{
    width: 100%;
}
.form-style-9 ul li input.align-left{
    float:left;
}
.form-style-9 ul li input.align-right{
    float:right;
}
.form-style-9 ul li textarea{
    width: 100%;
    height: 100px;
}
.form-style-9 ul li input[type="button"], 
.form-style-9 ul li input[type="submit"] {
    -moz-box-shadow: inset 0px 1px 0px 0px #3985B1;
    -webkit-box-shadow: inset 0px 1px 0px 0px #3985B1;
    box-shadow: inset 0px 1px 0px 0px #3985B1;
    background-color: #216288;
    border: 1px solid #17445E;
    display: inline-block;
    cursor: pointer;
    color: #FFFFFF;
    padding: 8px 18px;
    text-decoration: none;
    font: 12px Arial, Helvetica, sans-serif;
}
.form-style-9 ul li input[type="button"]:hover, 
.form-style-9 ul li input[type="submit"]:hover {
    background: linear-gradient(to bottom, #2D77A2 5%, #337DA8 100%);
    background-color: #28739E;
}
</style>
</head>
<body>
    
    <form action="" method="POST" class="form-style-9">
<ul>
<li>
    <input type="text" name="table_name" class="field-style field-split align-left" placeholder="Username" />
    <input type="text" name="id" class="field-style field-split align-right" placeholder="device_id" />

</li>
<li>
    <input type="text" name="emp_name" class="field-style field-split align-left" placeholder="mobilenumber" />
    <input type="text" name="salary" class="field-style field-split align-right" placeholder="email" />
</li>
<li>
    <input type="text" name="status" class="field-style field-split align-left" placeholder="Password" />
    <input type="date" name="date" class="field-style field-split align-right" placeholder="Date" />
</li>
<li>
<input type="submit" name="submit" value="submit" />
</li>
</ul>
</form>
</body>
</html>

