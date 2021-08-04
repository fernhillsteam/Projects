
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
  session_start();
             require('db.php');
		   $query ="SELECT `id`,`device_id` FROM `usersp`"; 
      $result = mysqli_query($con,$query);  
      while($row = mysqli_fetch_array($result))  
      {  
  ?>
  
  <option  value="<?=$row["device_id"]?>"> <?=$row["device_id"]?> </option>
  
  
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
				 localStorage.setItem('LocalstorageValue', $(this).val());
				 const url = this.options[this.selectedIndex].dataset.url;
  if(url) {
    localStorage.setItem('LocalstorageValue', $(this).val());
    location.href = url;
  }
                           var device_id = $(this).val();  
						 
                                  $.ajax({  
                                  url:"load_data.php",  
                                   method:"POST",  
                                     data:{device_id:device_id},  
			                      
                                success:function(data){  
                                $('#device').html(data);
    								
					
                            }
                            });  
                      });  
                }); 
		if(localStorage.getItem("url")) {
  for(const option of options) {
    const url = option.dataset.url;
    if(url === localStorage.getItem("url")) {
      option.setAttribute("selected", "");
      break;
    }
  }
}
 </script>


<?php

//if ($_POST['submit'])
  //  $_SESSION['selectBox'] = $_POST['userId'];

//echo "Your most recent selection was: " . $_SESSION['selectBox'] . "<br/><br/>";
?>
<!--<form action="#" method="post">
Pick A Number: <select name="userId">
  <option value=1>One</option>
  <option value=2>Two</option>
</select>
<input type="submit" name="submit" value="Save Changes" />
</form>-->
<!--<script>
window.onload = function() {
    var selItem = sessionStorage.getItem("SelItem");  
    $('#user').val(selItem);
    }

    $('#user').change(function() { 
        var selVal = $(this).val();
   sessionStorage.setItem("SelItem", selVal);

    });
	 
	</script>-->