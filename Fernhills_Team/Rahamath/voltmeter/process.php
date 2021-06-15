<?php
   $dbhost = 'localhost';
   $dbuser = 'u949021360_Pendios';
   $dbpass = 'Pendios@123';
   
   $conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   $sql = 'SELECT ac_v, ac_c, ac_p ,dc_v,dc_c,dc_p, time_stamp FROM voltmeter';
   mysql_select_db('u949021360_Pendios');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_assoc($retval)) {
      echo "EMP ID :{$row['ac_v']}  <br> ".
         "EMP NAME : {$row['ac_c']} <br> ".
         "EMP SALARY : {$row['ac_p']} <br> ".
         "EMP SALARY : {$row['dc_v']} <br> ".
         "EMP SALARY : {$row['dc_c']} <br> ".
         "EMP SALARY : {$row['dc_p']} <br> ".
         "EMP SALARY : {$row['time_stamp']} <br> ".
         "--------------------------------<br>";
         
   }
   
   echo "Fetched data successfully\n";
   
   mysql_close($conn);
?>



<!DOCTYPE html>
<html class=no-js lang="">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset=utf-8>
    <meta name=description content="">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title>Pendios Voltmeter</title>

     <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
 <link href="css/bootstrap.min.css" rel="stylesheet">
 
 <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
 <link rel=stylesheet href=style.css>
</head>
<body>
<div class= title_head>
	<p class="text1">PENDIOS</p>
	<p class="text2">PENDIOS</p>
	<p class="text3">VOLTEMTER</p>
</div>

<br/><br/>
<div class=container>
<div class="row">

        <div class="span6">

          <form class="form-signin">
            <h2 class="form-signin-heading">DC Parameters</h2><br/><br/>
            <label>Voltage
            	<input type="text" value="<?php echo $dc_v; ?>" /><span class="white">V</label>

            
           <label>Current
            	<input type="text" value="<?php echo $dc_c; ?>" /><span class="white">A</label>
            		 <label>Power
            	<input type="text" value="<?php echo $dc_p; ?>"/><span class="white">W</label>

            
           <label>Time Stamp
            	<input type="text" value="<?php echo $time_stamp; ?>"/><span class="white"></label>
           
          </form>
</div>


    

        <div class="span6">

          <form class="form-signin">
            <h2 class="form-signin-heading">AC Parameters</h2><br/><br/>
            <label>Voltage
            	<input type="text" value="<?php echo $ac_v; ?>" /><span class="white">V</label>

            
           <label>Current
            	<input type="text" value="<?php echo $ac_c; ?>" /><span class="white">A</label>
            		 <label>Power
            	<input type="text" value="<?php echo $ac_p; ?>"/><span class="white">W</label>

            
           <label>Time Stamp
            	<input type="text" value="<?php echo $time_stamp; ?>" /><span class="white"></label>
           
          </form>

      </div>
</div>
</div>
</body>

</html>

