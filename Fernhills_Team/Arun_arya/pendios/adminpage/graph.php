  
		
		    
<div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Voltage VS Time</h5>
                <p class="card-category">Bar Chart</p>
              </div>

              <div class="card-body ">

			  <canvas id="myChart" width="400" height="160"></canvas>
	    
	      <?php global $a;         


                $query ="SELECT `ac_v`,`dc_v`,`c_t` FROM `voltmeterp` WHERE `user_id`='".$a."'";
                $result = mysqli_query($con, $query) or die(mysql_error());
			    $data = array();


			    foreach($result as $value){
			           $data[] = $value;
			   }

		?>
			   <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.1/dist/chart.min.js"></script>

			    <script >


				 var data = <?php echo json_encode($data); ?>;
			
				 console.log(data);
                 var ac_v =[];
				 var dc_v =[];
				 var c_t  = [];
           
				 for(var i in data){
					ac_v .push( data[i].ac_v);
					dc_v .push( data[i].dc_v);
					 c_t.push(data[i].c_t);

				 }

				 var datas={
					 labels:c_t,
					 datasets:[{

						 label:'AC Voltage',
						 backgroundColor:'#FF8C00',
						 borderColor:'red',
						 data:ac_v
					 },
					 {

						 label:'DC Voltage',
						 backgroundColor:'#FFD700',
						 borderColor:'red',
						 data:dc_v
					 }]
				 }

			    var ctx =document.getElementById("myChart");

				var graph ={
					 type:'bar',
					 data:datas
					}

			              var bargraph = new Chart(ctx,graph);
				           console.log(bargraph);
                        </script>

               </div>
			</div>