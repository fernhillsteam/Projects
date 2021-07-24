<!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  
<?php
 global $a; 
 ?>
<div class="row">
	 <div class="col-md-12">
	
	  <div class="card">
              <div class="card-header">
               <!-- <h4 class="card-title">Device Status</h4>-->
              </div>
              <div class="card-body">
                <div class="row">			

	 <div class="col-lg col-md-6 col-6 ml-auto text-center">
		<div><i id="ind1" class='fas fa-circle ' ></i></div>
				 <p class="card-category text-center">Short Circuit</p>
                </div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		   <div><i id="ind2" class='fas fa-circle '></i></div>
				<p class="card-category text-center">Shutdown</p>
				</div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		     <div><i id="ind3" class='fas fa-circle '></i></div>
				<p class="card-category text-center">Overload</p>
				</div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		   <div><i id="ind4" class='fas fa-circle '></i></div>
				<p class="card-category text-center">Tampering</p>
		        </div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		<div><i id="ind5"class='fas fa-circle '></i></div>
				<p class="card-category text-center">Health</p>

				</div>
                  </div>

                  </div>
              </div>
		
			
			     
            
	   </div>
	   </div>
	 
	 
<script>
var id = <?php echo $a; ?>;

</script>

 <script>
if(typeof(EventSource) !== "undefined") {
  var source = new EventSource("indicatordata.php?a="+id);

  source.onmessage = function(event) {
   var eventid=event.lastEventId;
if(eventid==id){
   var myObj = JSON.parse(event.data);
     indcolor(1,myObj[0]);
     indcolor(2,myObj[1]);
     indcolor(3,myObj[2]);
     indcolor(4,myObj[3]);
	 indcolor(5,myObj[4]);
}

  };
} 

</script>
<script>
			
  function indcolor(ch,data){
	
switch(ch){

case 1:
     if (data == 1) {
    ind1.style.color = 'green';
	
  } else {
       ind1.style.color = 'red';
  }
    break;

case 2:

        if (data == 1) {

    ind2.style.color = 'green';
  } else {
      ind2.style.color = 'red';
  }
    break;
  

case 3:

        if (data == 1) {

    ind3.style.color = 'green';
  } else {
      ind3.style.color = 'red';
  }
    break;


 case 4:

       if (data == 1) {

    ind4.style.color = 'green';
  } else {
      ind4.style.color = 'red';
  }
    break;

case 5:

        if (data == 1) {

    ind5.style.color = 'green';
  } else {
      ind5.style.color = 'red';
  }
    break;
 
}

}
 </script>
