
	<style>
    	
     button{
            background-color: #c80e13;
     		color: white;
			border:none;
            font-family: Helvetica;
     		font-size: 16px;
     		border-radius: 12px;
		}

     button.foo { 
            background-color: #1c9517; 
        }


	</style>


      <!-- End Navbar -->
      <div class="content">
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
          <div class="col-md-12">
            <div class="card ">
             
			  
              <div class="card-body">
		 <div class="btn-class">
		  
                      <button  id="btn1" >Send SMS On Demand</button>
                      <button  id="btn2" >Update Server On Demand</button>
					  <button  id="btn3" >Authorize Access</button>
                      <button  id="btn4" >ShutDown</button>
			</div>
          
				  </div> 
              </div>
            </div>
          </div>
        </div>
      </div>
     
    </div>
  </div>
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
  disp();
  
 function disp(){
	
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

xmlhttp.open("GET", "actionvalue.php", true);
xmlhttp.send();

}




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
 