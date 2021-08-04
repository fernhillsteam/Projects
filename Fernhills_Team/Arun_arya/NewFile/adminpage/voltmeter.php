   
		
<?php

 global $a;


      $query = "SELECT * FROM `usersp` WHERE `device_id` = '".$a."'";  
      
      $result = mysqli_query($con, $query);  
      while($row = mysqli_fetch_array($result))  
      {
		   $username = $row["username"];
		
		  	$user = substr($username, 0, 2);
	        $voltTable = $user."".-$a."-vm";
			
	  $query = "SELECT * FROM `".$voltTable."` WHERE `device_id` = '".$a."'order by `sl_no` DESC limit 1 ";  
     
      $result = mysqli_query($con, $query);  

      while($row = mysqli_fetch_array($result))  
      {  
        ?>
		<div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i><img src="icons/voltage.png"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Voltage</p>
                      <p class="card-title"><?=$row["ac_v"]?>V <small>AC</small><p>
                      <p class="card-title"><?=$row["dc_v"]?>V <small>DC</small><p>  
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i><img src="icons/current.png"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Current</p>
                      <p class="card-title"><?=$row["ac_c"]?>A<p>
                      <p class="card-title"><?=$row["dc_c"]?>A<p>  
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar-o"></i>
                  Last day
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i> <img src="icons/power.png"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Power</p>
                      <p class="card-title"><?=$row["ac_p"]?>W<p>
                      <p class="card-title"><?=$row["dc_p"]?>W<p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-clock-o"></i>
                  In the last hour
                </div>
              </div>
            </div>
          </div>
        </div>
	<?php	
	       }
	  
	   }
	  
	  ?>