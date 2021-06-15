<?php

 include('connection.php');

?>

<!DOCTYPE html>
<html class=no-js lang="">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset=utf-8>
    <meta name=description content="">
    <meta http-equiv="refresh" content="10">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
         
    <title>Pendios Voltmeter</title>

     <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
 <link href="css/bootstrap.min.css" rel="stylesheet">
 
 <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
 <link rel=stylesheet href=style.css>
 <style>
   .nav-menu{
    float: right;
    margin-top: -80px;
    margin-right:50px;
   }
   .nav-menu li{
    font-family:Helvetica;
  font-size: 25px;
  color:#38619d;

   }
   .nav-menu li>a{
    float: right !important;
    font-family:Helvetica !important;
  font-size: 25px !important;
  color:#38619d !important;
  padding: initial !important;
  text-shadow: none !important;
  

   }
   .nav-menu{
    margin-right: 90px;
   }
   .led table{
    float: right;
    margin-right:60px;
    margin-top: -30px;
    color: black;
    background-color:#828689;
    border-radius: 20px;
    /*border:10px solid;*/
    border-color: #38619d;


   }
 #img1{
  float: right;
    margin-top: -90px;
    margin-right: 20px;
  }
 </style>

</head>
<body>
<div class= title_head>
  <p class="text1">&nbsp;&nbsp;PENDIOS</p>
  <p class="text2">&nbsp;&nbsp;PENDIOS</p>
  <p class="text3">IOT VOLTMETER</p>

<a href="javascript:location.reload(true)"><img id="img1" src="ref.png" alt="cannot display"></a>
<nav class=navbar>
   <div class=nav-menu>
          <ul class="nav navbar-nav menu-bar">
               <li><a href="index.php">Home &nbsp;&nbsp;</a></li>
               <li><a href="#">Configuration &nbsp;&nbsp;  </a></li>
                <li><a href="action.php">Actions &nbsp;&nbsp;  </a></li>
               <li><a href="#">Fault-Logs &nbsp; &nbsp; </a></li>
               <li><a href="deviceHistory.php">Device-History</a></li>
                  
      </ul>
    </div>
  </nav>



</div>
<div class="led">
<table id="ledTable" cellpadding="10px">
  <tr>
    <th><img id="img01" src="greenLed.png"></th>
     <th><img id="img02" src="greenLed.png" ></th>
      <th><img id="img03" src="greenLed.png" ></th>
       <th><img id="img04" src="greenLed.png"></th>
        <th><img id="img05"  src="greenLed.png" ></th>
      </tr>
      <tr>
        <th>Short Circuit</th>
        <th>Shutdown</th>
        <th>Overload</th>
        <th>Tampering</th>
        <th>Health</th>
      </tr>

</table>


</div>
 <script>
  function colorchange(ch,data){
switch(ch){
case 1:

    if(data==0){
      document.getElementById('img01').src="greenLed.png";
    }
    else{
      document.getElementById('img01').src="redLed.png";
    }
    break;

case 2:
 
    if(data==0){
      document.getElementById('img02').src="greenLed.png";
    }
    else{
      document.getElementById('img02').src="redLed.png";
    }
    break;

   case 3:
   
    if(data==0){
      document.getElementById('img03').src="greenLed.png";
    }
    else{
      document.getElementById('img03').src="redLed.png";
    }
    break; 

  case 4:
    if(data==0){
      document.getElementById('img04').src="greenLed.png";
    }
    else{
      document.getElementById('img04').src="redLed.png";
    }
    break;

    case 5:
    if(data==0){
      document.getElementById('img05').src="greenLed.png";
    }
    else{
      document.getElementById('img05').src="redLed.png";
    }
    break;

  }
}
  </script>

 <script>
function dis(){
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.responseText);
   colorchange(1,myObj[0]);
   colorchange(2,myObj[1]);
   colorchange(3,myObj[2]);
   colorchange(4,myObj[3]);
   colorchange(5,myObj[4]);
  }
};
xmlhttp.open("GET", "select.php", true);
xmlhttp.send();

}

dis();
setInterval(function(){
  dis();
},10000);



 </script>

<br/><br/><br/><br/><br/><br/><br/>


<div class=container>
<div class="row">

        <div class="span6">


          <?php
          $result = mysqli_connect($host,$uname,$pwd) or die("Could not connect to database." .mysqli_error());
  mysqli_select_db($result,$db_name) or die("Could not select the databse." .mysqli_error());
  $query = mysqli_query($result,"SELECT ac_v, ac_c, ac_p ,dc_v,dc_c,dc_p, time_stamp, c_t FROM voltmeter") or die("Could not find table".mysqli_error());

while($rowval = mysqli_fetch_array($query))

 {

$ac_v = $rowval['ac_v'];

$ac_c = $rowval['ac_c'];

$ac_p = $rowval['ac_p'];

$dc_v = $rowval['dc_v'];

$dc_c = $rowval['dc_c'];

$dc_p = $rowval['dc_p'];

$time_stamp = $rowval['time_stamp'];

$c_t = $rowval['c_t'];

/*$country= $rowval['country'];

$pin= $rowval['pcode'];

$mob= $rowval['con_no'];

$mailid= $rowval['mail_id'];

$uname= $rowval['uname'];

$balance= $rowval['balance'];*/

}

          ?>

          <form class="form-signin">
            <h2 class="form-signin-heading">DC Parameters</h2><br/><br/>
            <label>Voltage
              <input type="text" value='<?php echo  $dc_v; ?>' readonly/><span class="white">V</label>

            
           <label>Current
              <input type="text" value='<?php echo  $dc_c; ?>' readonly/><span class="white">A</label>
                 <label>Power
              <input type="text" value='<?php echo  $dc_p; ?>' readonly/><span class="white">W</label>

            
           <label>Time Stamp
              <input type="text" value='<?php echo  $time_stamp; ?>' readonly/><span class="white"></label>
           
          </form>
</div>


    

        <div class="span6">

          <form class="form-signin">
            <h2 class="form-signin-heading">AC Parameters</h2><br/><br/>
            <label>Voltage
              <input type="text" value='<?php echo  $ac_v; ?>' readonly/><span class="white">V</span></label>

            
           <label>Current
              <input type="text" value='<?php echo  $ac_c; ?>' readonly/><span class="white">A</span></label>
                 <label>Power
              <input type="text" value='<?php echo  $ac_p; ?>' readonly/><span class="white">W</span></label>

            
           <label>Time Stamp
              <input type="text" value='<?php echo  $time_stamp; ?>' readonly/><span class="white"></span></label>
           
          </form>

      </div>
      <center>
      <form class="form-signin">
        <label>LastUpdatedTime
              <input type="text" value='<?php echo  $c_t; ?>' readonly/><span class="white"></span></label>
      </form>
</div>
</div>
</body>

</html>
