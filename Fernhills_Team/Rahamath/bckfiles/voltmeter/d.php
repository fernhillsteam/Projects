<?php

 include('connection.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    border:10px solid;
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

<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
  <a class="navbar-brand" href="#"><p class="text1">&nbsp;PENDIOS</p>
  <p class="text2">&nbsp;PENDIOS</p>
  <p class="text3">IOT&nbsp;VOLTMETER</p></a>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php" style="font-size:25px;">Home &nbsp;&nbsp;</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" style="font-size:25px;">Configuration &nbsp;&nbsp;</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="action.php" style="font-size:25px;">Actions &nbsp;&nbsp;</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" style="font-size:25px;">Fault-Logs&nbsp;&nbsp;</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="deviceHistory.php" style="font-size:25px;">Device-History &nbsp;&nbsp;</a>
    </li>
  </ul>
</nav>

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
  $query = mysqli_query($result,"SELECT ac_v, ac_c, ac_p ,dc_v,dc_c,dc_p, time_stamp FROM voltmeter") or die("Could not find table".mysqli_error());

while($rowval = mysqli_fetch_array($query))

 {

$ac_v = $rowval['ac_v'];

$ac_c = $rowval['ac_c'];

$ac_p = $rowval['ac_p'];

$dc_v = $rowval['dc_v'];

$dc_c = $rowval['dc_c'];

$dc_p = $rowval['dc_p'];

$time_stamp = $rowval['time_stamp'];

/*$country= $rowval['country'];

$pin= $rowval['pcode'];

$mob= $rowval['con_no'];

$mailid= $rowval['mail_id'];

$uname= $rowval['uname'];

$balance= $rowval['balance'];*/

}

          ?>

          <!-- <form class="form-signin">
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
</div>
</div> -->
<div class="container-fluid" style="margin-top:200px">
 <!--  <h3>Under Process</h3>
  <p>A fixed navigation bar stays visible in a fixed position (top or bottom) independent of the page scroll.</p>
  <h1>Scroll this page to see the effect</h1> -->

</div>

</body>
</html>


