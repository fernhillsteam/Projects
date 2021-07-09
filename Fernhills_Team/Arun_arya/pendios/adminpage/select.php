
<div class="row">
	 <div class="col-md-12">
	
	  <div class="card">
              <div class="card-header">
               <h4 class="card-title">Select Device</h4>
              <div class="card-body">
                <div class="row">
		  <form class="col-md-12" method="post" >
	 
		   <select class="form-control select2" name="userId" id="user">
                  <option value="">Device ID</option>		   
  <?php   
             require('db.php');
		   $query ="SELECT `id`,`device_id` FROM `usersp`"; 
      $result = mysqli_query($con,$query);  
      while($row = mysqli_fetch_array($result))  
      {  
  ?>
  
  <option value="<?=$row["id"]?>"> <?=$row["device_id"]?> </option>
  
  
   <?php
      }
  ?>                 
						  
                     
           </select> 
      </form>
  </div>
				</div>
			  </div>
             </div>
    </div>
	
</div>	
<div class="row">
		<div class="col-md-12">
  
				<div class="" id="device">  
                      
				</div>              
		</div>  
  </div>    
		   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	
		   <script> 
          $(document).ready(function(){  
                 $('#user').change(function(){  
                           var user_id = $(this).val();  
                                  $.ajax({  
                                  url:"load_data.php",  
                                   method:"POST",  
                                     data:{user_id:user_id},  
			                      
                                success:function(data){  
                                $('#device').html(data);
    								
					
                            }
                            });  
                      });  
                });  
 </script>  
