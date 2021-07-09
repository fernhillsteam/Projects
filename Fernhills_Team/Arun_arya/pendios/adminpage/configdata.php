
	<!-- <div class="row">
				  <div class="col-lg-12 col-md-12 col-sm-14">
			     
				  <div class="text-right">
                      <button type="submit" class="btn btn-primary btn-round" onclick="exportTableToCSV( '<?php echo $current_date; ?>.csv')">Export</button>
                      <button type="submit" class="btn btn-primary btn-round"  onclick="PrintTable()">Print</button>
                  </div>
              </div>
			  </div>-->
	   <div class="row">	  
         <div class="col-lg-12 col-md-12 col-sm-14"> 
            <div class="card">
			<div class="card-header">
            <h3 class="card-title text-center">Configuration</h3>
              </div>
             <div class="card-body">
			  <div class="table-responsive-md">
			  <table class="table  table-hover " id="tableList" >
                    <thead class=" text-primary text-center">
                      <th>Device_ID</th>
                      <th>Mobile Number</th>
                      <th>Auth_Code</th>
                      <th>Server Link</th>
					  <th>APN</th>
                      <th>User Name</th>
                      <th>Password</th>
                      <th>Location</th>
					  <th>Address</th>
					  <th>Edit</th>
                    </thead>
                    <tbody>
                        <?php
				 
						 
                $query ="SELECT * FROM `configuration` WHERE `user_id`='".$a."'";
                $result = mysqli_query($con, $query) or die(mysql_error());
  				if(mysqli_num_rows($result) >0){
  					foreach($result as $row) {
  							?>
  							<tr>
  								<td align="center" id="device"><?=$row['device_id']; ?></td>
  								<td align="center" id="mobile"><?=$row['mobile_number']; ?></td>
  								<td align="center" id="auth"><?=$row['auth_code']; ?></td>
  								<td align="center" id="server"><?=$row['server_link']; ?></td>
  								<td align="center" id="apn"><?=$row['apn']; ?></td>
  								<td align="center" id="user"><?=$row['username']; ?></td>
  								<td align="center" id="pwd"><?=$row['password']; ?></td>
  								<td align="center" id="location"><?=$row['location']; ?></td>
								<td align="center" id="address"><?=$row['address']; ?></td>
								<td align="center">
								<a href="config.php?edit=<?php echo $row['user_id']; ?>" method= "GET" class="edit_btn" id="edit" >
								<input type="submit" class="btn btn-primary" value="Edit">
								</a></td>
  							</tr>
  							<?php
  					}
  				}
  				
				 
            ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>   
      </div>
    
	

  <!--<script type="text/javascript">
    $("#edit").click(function() {
           var device = $('#device').val(); 
           var mobile = $('#obile').val(); 
           var auth=$('#auth').val();		   
           var server= $('#server').val();
            var apn=$('#apn').val();
            var user =$('#user').val();			
		    var pwd=$('#pwd').val();
            var location=$('#location').val();
            var address =$('#address').val();			
		 			
        $.ajax ({
	       url: 'config.php',
           type: 'post',
           data: {device:device, mobile:mobile, auth:auth, server:server, apn:apn, user:user, pwd:pwd, location:location, address:address},
            success: function(data) {
				
                alert(data);
            }
        });
    });
</script>-->