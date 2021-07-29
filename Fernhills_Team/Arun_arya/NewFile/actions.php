<?php global $a;
		
		?>

	<style>
     button{      
		    width:100%;
	 }
      
	</style>


      <!-- End Navbar -->
   			<div class="row">
			
	 <div class="col-md-12">
	  <div class="card">
              <div class="card-header">
               <!-- <h4 class="card-title">Device Status</h4>-->
              </div>
              <div class="card-body">
                <div class="row">			   
				 <div  class="col-lg-6 col-md-6 col-sm-6 text-center">
				 <!--<div><i id="status1" class='fas fa-circle ' ></i></div>-->
				 <div class="list-group">
				 <div class="list-group-item"><i id="status1" class='fas fa-circle ' ></i></div>
				 </div>
				 
				 <div><button id="1" class="btn btn-primary">Send SMS On Demand</button></div>
                </div>
				<div class="col-lg-6 col-md-6 col-sm-6 text-center">
				<!--<div><i  id="status2"class='fas fa-circle ' ></i></div>-->
				<div class="list-group">
				 <div class="list-group-item"><i id="status2" class='fas fa-circle ' ></i></div>
				 </div>
		        <div><button id="2" class="btn btn-primary">Update Server On Demand</button></div>
				<p class="card-category text-center"></p>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 text-center">
				<!--<div><i id="status3" class='fas fa-circle ' ></i></div>-->
				<div class="list-group">
				 <div class="list-group-item"><i id="status3" class='fas fa-circle ' ></i></div>
				 </div>
		        <div><button id="3" class="btn btn-primary">Authorize Access</button></div>
				<p class="card-category text-center"></p>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 text-center">
				<!--<div><i id="status4" class='fas fa-circle ' ></i></div>-->
					<div class="list-group">
				 <div class="list-group-item"><i id="status4" class='fas fa-circle ' ></i></div>
				 </div>
		       <div><button  id="4" class="btn btn-primary"  >ShutDown</button></div>
				<p class="card-category text-center"></p>
		        </div>
				</div>

                  </div>    
            
	   </div>
	              </div>    
            
	   </div>
	 <!--  <div class="container">
            <div class="d-inline-block">
                <ul class="list-group">
                    <li class="list-group-item">one</li>
                    <li class="list-group-item">two</li>
                    <li class="list-group-item">three</li>
                    <li class="list-group-item">four</li>
                    <li class="list-group-item">five</li>
                </ul>
            </div>-->
	  
        	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>


			<!--<script>
			var clicked = false;

function toggleBtnClick() {
  var img = document.getElementById('btn4');
  if (clicked) {
   img.style.color = 'green';
    clicked = false;
  } else {
   img.style.color = 'red';
    clicked = true;
  }
}
</script>	-->
<!--<script>
         	 var clicked = false;
			 
			   $(document).ready(function () {
                     
                       $("button").click(function () {
            
						 
                        var ele = $(this).attr('id');
						alert(ele);
						alert(clicked);
					
                                 if (clicked) {
									
                                      update1(ele,y);
									   clicked = false;
                                       } else {
										
                                      update0(ele,y);
									   clicked = true;
									 
                                     }

                      });
                  });
	
	


			</script>-->
		
     
  <!--   Core JS Files   -->
     
<script>
var y = <?php echo $a; ?>;

</script>

<script>

if(typeof(EventSource) !== "undefined") {
	
  var source = new EventSource("actionvalue.php?b="+y);
  source.onmessage = function(event) {
	  
 var eventid=event.lastEventId;
if(eventid==y){	  
   var myObj = JSON.parse(event.data);

     setcolor(1,myObj[0]);
     setcolor(2,myObj[1]);
     setcolor(3,myObj[2]);
     setcolor(4,myObj[3]);


}
     
  };


} 



</script>
 <script>
			   $(document).ready(function () {
                     
                       $("button").click(function () {
						 
                        var ele = $(this).attr('id');
						$.ajax({
                              type: "GET",
                               url: 'btnvalue.php',
                              data: {id:y, btn: ele},
                           success: function(data){
                                     // alert(data);
									  if (data==1) {	
									  
                                           update0(ele,y);
										   
					                         } else {
												 
                                                update1(ele,y);
					   			 
	     			                               }
                                               }
                                    });
                      });
                  });
				  
			</script>

<script>
			
  function setcolor(ch,data){
switch(ch){
case 1:

    if (data == 1) {
   status1.style.color = 'green';
	
  } else {
    status1.style.color = 'red';
	 
  }
    break;

case 2:

     if (data == 1) {
  status2.style.color = 'green';
	
	
  } else {
   status2.style.color = 'red';

  }
    break;

case 3:

     if (data == 1) {
status3.style.color = 'green';
	
	
  } else {
     status3.style.color = 'red';
	
  }
    break;

 case 4:

     if (data == 1) {
     status4.style.color = 'green';

	
  } else {
      status4.style.color = 'red';
	
  }
    break;

 
}
}
 </script>


 <script>



var y = <?php echo $a; ?>;

 </script>

<script>
 	function update1(ele,y) {

 		$.ajax({
            url: "update1.php",
            type: "POST",
            data: {btn: ele, id:y },                   
            success: function(data)
                        {
                                                     
                        }
        });
 		
 	}
 </script>

<script>
	function update0(ele,y) {

 		$.ajax({
            url: "update0.php",
            type: "POST",
            data: {btn: ele, id:y },                   
            success: function(data)
                        {
                                                         
                        }
        });
 		
 	}
</script>
 