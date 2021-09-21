
 <?php global $a;
				  
      $current_date = date('Y-m-d');
	  ?>
 
      
	 <div class="row">
				  <div class="col-lg-12 col-md-12 col-sm-14">
			     
				  <div class="text-right">
                      <input type="submit" class="btn btn-primary btn-round" id="exportF" onclick="exportTableF_ToCSV( 'Fault logs <?php echo $current_date; ?>.csv')" value="Export">
                      <input type="submit" class="btn btn-primary btn-round"  id = "printF" onclick="PrintTableF()" value="Print">
                  </div>
              </div>
			  </div>
	   <div class="row">	  
         <div class="col-lg-12 col-md-12 col-sm-14"> 
            <div class="card">
			<div class="card-header">
            <h3 class="card-title text-center">Fault Log</h3>
              </div>
             <div class="card-body">
			  <div class="table-responsive-md">
			  <table class="table  table-hover " id="tableF" >
                    <thead class=" text-primary text-center" >
                      <th>Sl_no</th>
                      <th>Fault Logs</th>
                      <th>Time</th>
                    </thead>
                    <tbody>
                        <?php
				 $query = "SELECT * FROM `usersp` WHERE `device_id` = '".$a."'";  
      
                  $result = mysqli_query($con, $query);  
						 
                       while($row = mysqli_fetch_array($result))  
                       {
		                           $username = $row["username"];
		
		  	                       $user = substr($username, 0, 2);
	                               $faultTable = $user."".-$a."-fl";
			
	                               $query = "SELECT * FROM `".$faultTable."` WHERE `device_id` = '".$a."'";  
      
                                   $result = mysqli_query($con, $query) or die(mysql_error());
				
  				if(mysqli_num_rows($result) >0){
  					foreach($result as $row) {
  							?>
  							<tr>
  								<td align="center"><?=$row['sl_no']; ?></td>
  								<td align="center"><?=$row['fault_log']; ?></td>
  								<td align="center"><?=$row['time']; ?></td>
  							</tr>
  							<?php
  					}
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
    
   <!--   Core JS Files   -->
       
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js" ></script> 

  <script>


    function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
  }
  
function exportTableF_ToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("#tableF tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}


     </script>
   
     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  
 <script>
    $(document).ready(function(){
    $('#tableF').DataTable();

         });
	function PrintTableF() {
       var tab = document.getElementById('tableF');
	   console.log(tab)
       var style = "<style>";
                style = style + "table {width: 100%;font: 17px Calibri;}";
                style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
                style = style + "padding: 2px 3px;text-align: center;}";
                style = style + "</style>";

             var win = window.open('', '', 'height=700,width=700');
             win.document.write(style);          //  add the style.
             win.document.write(tab.outerHTML);
             win.document.close();
             win.print();
        }
  </script> 