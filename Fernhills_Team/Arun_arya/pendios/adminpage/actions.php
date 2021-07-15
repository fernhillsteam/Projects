
	<style>
    	
     button{
            background-color: #c80e13;
     		color: white;
			border:none;
			outline: none !important;
            font-family: Helvetica;
     		font-size: 16px;
     		border-radius: 10px;
		    width:80%;
			height:75%;
			margin:5px;

		}

     button.foo { 
            background-color: #1c9517; 
			
        }


	</style>


      <!-- End Navbar -->
   
	     <?php global $a;
		
		?>
        	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script>	
		var x = <?php echo $a; ?>;
		</script>
			   <script>
			   $(document).ready(function () {
                     
                       $("button").click(function () {
						 
                         $(this).toggleClass('foo');
                        var ele = $(this).attr('id');
                        if ($(this).css("background-color") == "rgb(200, 14, 19)" ) {
                             	update0(ele,x);

                           } 
                         if($(this).css("background-color") == "rgb(28, 149, 23)"){
       		                   update1(ele,x);
                          }


                      });
                  });
				  
			</script>
			<div class="row">
	 <div class="col-md-12">
	  <div class="card">
              <div class="card-header">
               <!-- <h4 class="card-title">Device Status</h4>-->
              </div>
              <div class="card-body">
                <div class="row">			   
				 <div class="col-lg-6 col-md-6 col-sm-6 text-center">
				<button  id="btn1" >Send SMS On Demand</button> 
				 <p class="card-category text-center"></p>
                </div>
				<div class="col-lg-6 col-md-6 col-sm-6 text-center">
		        <button  id="btn2" >Update Server On Demand</button>
				<p class="card-category text-center"></p>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 text-center">
		        <button  id="btn3" >Authorize Access</button>
				<p class="card-category text-center"></p>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 text-center">
		       <button  id="btn4" >ShutDown</button>
				<p class="card-category text-center"></p>
		        </div>
				</div>

                  </div>    
            
	   </div>
	              </div>    
            
	   </div>
	 <!--  </div>
	  <div class="card">
  <div class="card-body">
		<!--<div class="row">
		    <div class="col-lg col-md-5 col-6 col-sm-6 ml-auto ">

                      <button  id="btn1" >Send SMS On Demand</button>  
				</div>	  
				<div class="col-lg col-md-5 col-sm-6 col-6 ml-auto">
                      <button  id="btn2" >Update Server On Demand</button>
				</div>	
                <div class="col-lg col-md-5 col-sm-6 col-6 ml-auto">				
					  <button  id="btn3" >Authorize Access</button>
			    </div>
				 <div class="col-lg col-md-5  col-sm-6 col-6 ml-auto">
                      <button  id="btn4" >ShutDown</button>
				 </div>	  
		          </div> 
				  
					<div class="row">
	 <div class="col-md-12">	  
				     <div class="row">
      <div class="col-sm" > <button  id="btn1" >Send SMS On Demand</button>  </div>
      <div class="col-sm" ><button  id="btn2" >Update Server On Demand</button></div>
      <div class="col-sm" ><button  id="btn3" >Authorize Access</button></div>
      <div class="col-sm" ><button  id="btn4" >ShutDown</button></div>
    </div>
   
           </div> 
				</div> 
              </div>
            </div>-->
          
      
  <!--   Core JS Files   -->
  		
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

 
}
}
 </script>

 <script>


 function disp(x){
	
var xmlhttp = new XMLHttpRequest();
xmlhttp.onload = function() {
	 
  if (this.readyState == 4 && this.status == 200) {
	
	     
    var myObj = JSON.parse(this.responseText);
	
   setcolor(1,myObj[0]);
   setcolor(2,myObj[1]);
   setcolor(3,myObj[2]);
   setcolor(4,myObj[3]);

  }

};

xmlhttp.open("GET", "actionvalue.php?q=" + x,true);
xmlhttp.send();

}


var x = <?php echo $a; ?>;


 disp(x);
 

 </script>

 <script>
 	function update1(ele,x) {
 		$.ajax({
            url: "update1.php",
            type: "POST",
            data: {btn: ele, id:x },                   
            success: function(data)
                        {
                                                     
                        }
        });
 		
 	}
 </script>

<script>
	function update0(ele) {
 		$.ajax({
            url: "update0.php",
            type: "POST",
            data: {btn: ele, id:x  },                   
            success: function(data)
                        {
                                                         
                        }
        });
 		
 	}
</script>
 