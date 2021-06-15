<?php

 include('connection.php');

?>

<!DOCTYPE html>
<html class=no-js lang="">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset=utf-8>
    <meta name=description content="">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
      
    <title>Device History</title>
     <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
     <link href="https://cdn.datatables.net/1.10.24/css/dataTables.jqueryui.min.css" rel="stylesheet">
     <link rel=stylesheet href=style.css>
     <style>
     	.title p{
     		margin-left: 80px;
     		font-family:Helvetica;
  font-size: 30px;
  color:#38619d;
  margin-top: -50px;
    	}
     	#example_wrapper{
     		margin-left: 50px;
     		margin-right: 50px;
     		padding-left:80px;
     		padding-right:80px;
     	}
     	#export{
     		float:right;
     		margin-right: 60px;
     		margin-bottom: 20px;
     		background-color:#008CBA;
     		color: white;
     		padding:  15px 30px;
     		cursor: pointer;
     		display: inline-block;
     		font-family: Helvetica;
     		font-size: 16px;
     		border:none;
     		border-radius: 12px;

     	}
     	#print{
     		float:right;
     		margin-right: 300px;
     		margin-bottom: 20px;
     		background-color:#008CBA;
     		color: white;
     		padding:  15px 30px;
     		cursor: pointer;
     		display: inline-block;
     		font-family: Helvetica;
     		font-size: 16px;
     		border:none;
     		border-radius: 12px;

     	}
     	 #img1{
  float: right;
  	margin-top: -70px;
  	margin-right: 20px;
  }
     </style>
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
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
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
 </head>
 <body>
 	<div class="title">
 		<a href="index.php"><img src="a2.png" style="margin-top: 20px;padding-left: 5px;"></a>
 		<p>History</p>
 	</div>
 		<a href="javascript:location.reload(true)"><img id="img1" src="ref.png" alt="cannot display"></a>
<br/><br/>
 	<div class="history-table">	
 		<button id="print" onclick="PrintTable()">Print</button>
 		<button id="export" onclick="exportTableToCSV('29-04-2021.csv')">Export</button>
 		<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Sl_no</th>
                <th>AC Voltage</th>
                <th>AC Current</th>
                <th>AC Power</th>
                <th>DC Voltage</th>
                <th>DC Current</th>
                <th>DC Power</th>
                <th>Time Stamp</th>
            </tr>
        </thead>
        <tbody>
           <?php
           $result = mysqli_connect($host,$uname,$pwd) or die("Could not connect to database." .mysqli_error());
  mysqli_select_db($result,$db_name) or die("Could not select the databse." .mysqli_error());
  $query = mysqli_query($result,"SELECT Sl_no,ac_v, ac_c,ac_p ,dc_v,dc_c,dc_p, time_stamp FROM voltmeter limit 100") or die("Could not find table".mysqli_error());
  				if(mysqli_num_rows($query) >0){
  					foreach($query as $row) {
  							?>
  							<tr>
  								<td align="center"><?=$row['Sl_no']; ?></td>
  								<td align="center"><?=$row['ac_v']; ?></td>
  								<td align="center"><?=$row['ac_c']; ?></td>
  								<td align="center"><?=$row['ac_p']; ?></td>
  								<td align="center"><?=$row['dc_v']; ?></td>
  								<td align="center"><?=$row['dc_c']; ?></td>
  								<td align="center"><?=$row['dc_p']; ?></td>
  								<td align="center"><?=$row['time_stamp']; ?></td>
  							</tr>
  							<?php
  					}
  				}
  				else{
  					?>
  					<tr>
  						<td colspan="6">No Record Found</td>
  					</tr>
  					<?php

  				}
           
            ?>
        </tbody>
    </table>


 	</div>
 	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.jqueryui.min.js"></script>
 	<script>		
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script>
	function PrintTable() {
       var tab = document.getElementById('example');
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


 </body>
 </html>