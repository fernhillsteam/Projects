
  
		

<div class="row">
	 <div class="col-md-12">
	
	  <div class="card">
              <div class="card-header">
               <!-- <h4 class="card-title">Device Status</h4>-->
              </div>
              <div class="card-body">
                <div class="row">			  
  <?php  global $a;
  
                         $query ="SELECT * FROM `indicator` WHERE `user_id` = '".$a."' order by `Sl_no` DESC limit 1 ";
                         $result = mysqli_query($con, $query) or die(mysql_error());
               
			     while($row = mysqli_fetch_row($result)){

                    $short  =$row[2];
					$shutdown=$row[3];
					$overload=$row[4];
					$tamper=$row[5];
					$health=$row[6];

     ?>
				 <div class="col-lg col-md-6 col-6 ml-auto text-center">
				<?php echo  "<div style='color: ".($short == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				 <p class="card-category text-center">Short Circuit</p>
                </div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		        <?php echo  "<div style='color: ".($shutdown == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				<p class="card-category text-center">Shutdown</p>
				</div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		        <?php echo  "<div style='color: ".($overload == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				<p class="card-category text-center">Overload</p>
				</div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		        <?php echo  "<div style='color: ".($tamper == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				<p class="card-category text-center">Tampering</p>
		        </div>
				<div class="col-lg col-md-6 col-6 ml-auto text-center">
		        <?php echo  "<div style='color: ".($health == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
				<p class="card-category text-center">Health</p>

				</div>
		<?php
							  } 

?>


                  </div>

                  </div>
              </div>
		
			
			     
            
	   </div>
	   </div>