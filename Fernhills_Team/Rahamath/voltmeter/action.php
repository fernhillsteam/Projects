<?php

 include('connection.php');

?>

<!DOCTYPE html>
<html class=no-js lang="">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset=utf-8>
    <meta name=description content="">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
   
    <title>Actions</title>
    <link rel=stylesheet href=style.css>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js">
</script>
<script>

$(document).ready(function () {
    $("button").click(function () {
       $(this).toggleClass('foo');
       var ele = $(this).attr('id');
       if ($(this).css("background-color") == "rgb(200, 14, 19)" ) {
       	updatecolor(ele);

       } 
       if($(this).css("background-color") == "rgb(28, 149, 23)"){
       		updatevalue(ele);
       }


});


   });


</script>
    <style>
    	.title p{
     		margin-left: 80px;
     		font-family:Helvetica;
  font-size: 30px;
  color:#38619d;
  margin-top: -50px;
    	}
button{
background-color: #c80e13;
     		color: black;
     		padding:  20px 30px;
     		display: inline-block;
     		font-family: Helvetica;
     		font-size: 16px;
     		border:none;
     		border-radius: 12px;
     		position: relative;
     		top: 50%;
     		left: 40%;
     		margin-bottom: 30px;
}

button.foo { 
  background-color: #1c9517; 
  }

  #img1{
  float: right;
  	margin-top: -70px;
  	margin-right: 20px;
  }
</style>
</head>
<body>
<div class="title">
 		<a href="index.php"><img src="a2.png" style="margin-top: 20px;padding-left: 5px;"></a>
 		<p>Actions</p>
 	</div>
 	<a href="javascript:location.reload(true)"><img id="img1" src="ref.png" alt="cannot display"></a>
<br/> <br/> <br/> <br/>
 <div class="btn-class">

 	<button id = "btn1" >Send_sms_On_demand</button> <br/>
 	<button id = "btn2" >Update_server_On_demand</button> <br/>
 	<button id = "btn3" >Authorize Access</button> <br/>
 	<button id = "btn4" >Shutdown Device</button> <br/>
 	<!-- <button id = "btn5" >Button5</button> <br/> -->

 	
 </div>
 <script>
  function setcolor(ch,data){
switch(ch){
case 1:

    if(data==1){
      $('#btn1').toggleClass('foo');
    }
    break;

case 2:

    if(data==1){
      $('#btn2').toggleClass('foo');
    }
    
    break;

case 3:

    if(data==1){
     $('#btn3').toggleClass('foo');
    }
    
    break;

 case 4:

    if(data==1){
      $('#btn4').toggleClass('foo');
    }
   
    break;

    case 5:

    if(data==1){
     $('#btn5').toggleClass('foo');
    }
    break;

}
}
 </script>

 <script>
 function disp(){
var xmlhttp = new XMLHttpRequest();
xmlhttp.onload = function() {
  if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.responseText);
   setcolor(1,myObj[0]);
   setcolor(2,myObj[1]);
   setcolor(3,myObj[2]);
   setcolor(4,myObj[3]);
   setcolor(5,myObj[4]);
  }
};
xmlhttp.open("GET", "value.php", true);
xmlhttp.send();

}

disp();


 </script>

 <script>
 	function updatevalue(ele) {
 		$.ajax({
            url: "update.php",
            type: "POST",
            data: {'colname': ele },                   
            success: function(data)
                        {
                                                              
                        }
        });
 		
 	}
 </script>

<script>
	function updatecolor(ele) {
 		$.ajax({
            url: "update1.php",
            type: "POST",
            data: {'colname': ele },                   
            success: function(data)
                        {
                                                            
                        }
        });
 		
 	}
</script>
</body>
</html>