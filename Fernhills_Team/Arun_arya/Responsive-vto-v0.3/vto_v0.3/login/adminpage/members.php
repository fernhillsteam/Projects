<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================
* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by www.creative-tim.com
 =========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php
include '../inc/header.php';

Session::CheckSession();

?>
<?php

if (isset($_GET['remove'])) {
  $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  $removeUser = $users->deleteUserById($remove);
}

if (isset($removeUser)) {
  echo $removeUser;
}
if (isset($_GET['deactive'])) {
  $deactive = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['deactive']);
  $deactiveId = $users->userDeactiveByAdmin($deactive);
}

if (isset($deactiveId)) {
  echo $deactiveId;
}
if (isset($_GET['active'])) {
  $active = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['active']);
  $activeId = $users->userActiveByAdmin($active);
}

if (isset($activeId)) {
  echo $activeId;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/images/vto-logo.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  
  <title>
    VTO Admin Dashboard
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<style>
 .label-default {
  background-color: #22686c;
  border-radius:5px;
  color:white;
  padding:2px;
  font-size: 12px;
  font-weight: 900;
}
  .label-primary {
  background-color: #00A388;
  border-radius:5px;
  color:white;
  padding:2px 5px ;
  font-size: 12px;
  font-weight: 900;
}
  .label-info {
  background-color: #3f9cff;
  border-radius:5px;
  color:white;
  padding:2px 14px ;
  font-size: 12px;
  font-weight: 900;
}
 .label-success {
  background-color: #0cc70c;
  border-radius:5px;
  color:white;
  padding:2px 15px;
  font-size: 12px;
  font-weight: 900;
}

.label-danger {
  background-color: #ff2727;
  border-radius:5px;
  color:white;
  padding:2px 7px;
  font-size: 12px;
  font-weight: 900;
}
</style>
<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="success">
      <div class="logo">
        <a href="./dashboard.php" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/images/vto-logo.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="#" class="simple-text logo-normal">
          <strong>VTO</strong>
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li >
            <a href="./dashboard.php">
              <i> <img src="../assets/icons/dashboard.png"></i>
              <p><strong>Dashboard</strong></p>
            </a>
          </li>
		  <li>
            <a href="./slider.php">
              <i> <img src="../assets/icons/image.png"></i>
              <p><strong>Add Slider</strong></p>
            </a>
          </li>
		  <li>
            <a href="./gallery.php">
              <i> <img src="../assets/icons/image.png"></i>
              <p><strong>Add Gallery</strong></p>
            </a>
          </li>
		  <li class="active ">
            <a href="./members.php">
              <i> <img src="../assets/icons/members.png"></i>
              <p><strong>Manage Members</strong></p>
            </a>
          </li>
		  <li>
            <a href="./addmember.php">
              <i> <img src="../assets/icons/addmember.png"></i>
              <p><strong>Add Members</strong></p>
            </a>
          </li>
		  <li>
            <a href="../calender1/eventmanage.php">
              <i> <img src="../assets/icons/events.png"></i>
              <p><strong>Manage Events</strong></p>
            </a>
          </li>
          <li>
            <a href="#">
              <i> <img src="../assets/icons/analytics.png"></i>
              <p><strong>Analytics</strong></p>
            </a>
          </li>
		  <li>
            <a href="#">
              <i> <img src="../assets/icons/contacts.png"></i>
              <p><strong>Contact</strong></p>
            </a>
          </li>
      <!--    <li>
            <a href="">
              <i class="nc-icon nc-settings"></i>
              <p>Configuration Page</p>
            </a>
          </li>-->
          <li>
            <a href="?action=adminlogout">
              <i> <img src="../assets/icons/logout.png"></i>
              <p><strong>Log Out</strong></p>
            </a>
          </li>

        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;"><strong>Manage Members</strong></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
       
            <ul class="navbar-nav">
			  <li class="nav-item d-flex align-items-center">
              
			  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><strong>
				<?php
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?></strong></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="?action=adminlogout">Logout</a>

                </div>
            </li>
            
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
	
	   <div class="content">
        	
		<div class="row">	  
         <div class="col-lg-12 col-md-12 col-sm-14"> 
            <div class="card">
             <div class="card-body">
			  <div class="table-responsive-md">
			  <table class="table  table-hover w-auto" id="tableList" >
                  <thead>
                    <tr>
                      <th class="text-center">SL</th>
                     <!-- <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>-->
                      <th class="text-center">Username</th>
					  <th class="text-center">Designation</th>
					  <th class="text-center">Business</th>
                      <th class="text-center">Email address</th>
                      <!--<th>Mobile</th>-->
                      <th class="text-center">Status</th>
                      <th class="text-center">Created</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $allUser = $users->selectAllUserData();
                      
                      if ($allUser) {
                        $i = 0;
                        foreach ($allUser as  $value) {
                          $i++;

                     ?>

                      <tr class="text-center"
                      <?php if (Session::get("id") == $value->id) {
                        echo "style='background:#d9edf7' ";
                      } ?>
                      >
                        <td><?php echo $i; ?></td>
						
                       <!-- <td><h6 class="mb-0 text-sm"><?php echo $value->name; ?></h6></td>-->
                        <td><?php echo $value->username; ?> <br>
                          <?php if ($value->roleid  == '1'){
                          echo "<span class='label label-primary'>Admin</span>";
                        } elseif ($value->roleid == '2') {
                          echo "<span class='label label-info'>Editor</span>";
                        }elseif ($value->roleid == '3') {
                            echo "<span class='label label-default'>User Only</span>";
                        } ?></td>
						
						<td><?php if ($value->designation  == '1'){
                          echo "<span class=''><strong>Prime</strong></span>";
                        } elseif ($value->designation == '2') {
                          echo "<span class=''><strong>Mentor</strong></span>";
                        }elseif ($value->designation == '3') {
                            echo "<span class=''><strong>Vice President</strong></span>";
                        } ?></td>
						  
						<td><?php echo $value->business; ?></td>
						
                        <td><?php echo $value->email; ?></td>

                        <!--<td><?php echo $value->mobile; ?></td>-->
                        <td>
                          <?php if ($value->isActive == '0') { ?>
                          <span class="label label-success">Active</span>
                        <?php }else{ ?>
                    <span class="label label-danger">Deactive</span>
                        <?php } ?>

                        </td>
                        <td><?php echo $users->formatDate($value->created_at);  ?></td>

                        <td>
                          <?php if ( Session::get("roleid") == '1') {?>
						    
							<!--<button class="btn bg-gradient-info toast-btn viewBtn" id="<?php echo $value->id; ?>" ><span class="material-icons">find_in_page</span></button>-->
							<a href="view1.php?id=<?php echo $value->id;?>" class="viewBtn" id="<?php echo $value->id; ?>"><i><img src="../assets/icons/view.png"></i></a>
							
                            <!--<button class="btn bg-gradient-secondary toast-btn editBtn " id="<?php echo $value->id; ?>" ><span class='material-icons'>edit_note</span></button>-->
							<a href="edit1.php?id=<?php echo $value->id;?>" ><i><img src="../assets/icons/edit.png"></a>
							
                            <!--<a onclick="return confirm('Are you sure To Delete ?')" class="btn bg-gradient-warning toast-btn
                    <?php if (Session::get("id") == $value->id) {
                      echo "disabled";
                    } ?>
                              " href="?remove=<?php echo $value->id;?>"><i class="fas fa-trash-alt"></i></a>-->
                            <a onclick="return confirm('Are you sure To Delete ?')" 
                    <?php if (Session::get("id") == $value->id) {
                      echo "disabled";
                    } ?>
                           href="?remove=<?php echo $value->id;?>" ><i><img src="../assets/icons/delete.png"></a>
							  
                             <?php if ($value->isActive == '0') {  ?>
                               <a onclick="return confirm('Are you sure To Deactive ?')" class="btn btn-danger
                       <?php if (Session::get("id") == $value->id) {
                         echo "disabled";
                       } ?>
                                 " href="?deactive=<?php echo $value->id;?>">Disable</a>
								
                             <?php } elseif($value->isActive == '1'){?>
                               <a onclick="return confirm('Are you sure To Active ?')" class="btn btn-success 
                       <?php if (Session::get("id") == $value->id) {
                         echo "disabled";
                       } ?>
                                " href="?active=<?php echo $value->id;?>">Active</a>
                             <?php } ?>




                        <?php  }elseif(Session::get("id") == $value->id  && Session::get("roleid") == '2'){ ?>
                          <button class="btn btn-success btn-sm " >View</button>
                          <button class="btn btn-info btn-sm " >Edit</button>
                        <?php  }elseif( Session::get("roleid") == '2'){ ?>
                          <a class="btn btn-success btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
						  
                          " href="profile.php?id=<?php echo $value->id;?>">View</a>
                          <a class="btn btn-info btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">Edit</a>
                        <?php }elseif(Session::get("id") == $value->id  && Session::get("roleid") == '3'){ ?>
                          <button class="btn btn-success btn-sm ">View</button>
                          <button class="btn btn-info btn-sm " >Edit</button>
                        <?php }else{ ?>
                          <a class="btn btn-success
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">View</a>

                        <?php } ?>

                        </td>
                      </tr>
                    <?php }}else{ ?>
                      <tr class="text-center">
                      <td>No user availabe now !</td>
                    </tr>
                    <?php } ?>
                  </tbody>
                 
                </table>
				<?php
				$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
  echo $logMsg;
}

Session::set("msg", NULL);
Session::set("logMsg", NULL);
?>
                </div>
              </div>
            </div>
          </div> 
		  
      </div>
	  					  
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, All rights reserved by Vokkaligara Trade Organisation Dashboard
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
 
	 <!-- VIEW MODAL -->
 <!--<div class="modal fade" id="viewModal"  tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">View Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close">×</button>
        </div>

        <!-- Place to print the fetched phone -->
        <!--<div id="view_result"></div>

   </div>
  </div>-->
  
  
 

  <!--   Core JS Files   -->
  
  
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
 
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script> 
 <script>
    $(document).ready(function(){
    $('#tableList').DataTable();

         });
		 
	function PrintTable() {
       var tab = document.getElementById('tableList');
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
  <script type="text/javascript">
     // Start jQuery function after page is loaded
        $(document).ready(function(){
            $('.viewBtn').click(function(){
				
			var id = $(this).attr('id');
                // Start AJAX function
                $.ajax({
                 // Path for controller function which fetches selected phone data
                    url: "view1.php",
                    // Method of getting data
                    method: "GET",
                    // Data is sent to the server
                    data: {id:id},
                    // Callback function that is executed after data is successfully sent and recieved
                    success: function(data){
                     // Print the fetched data of the selected phone in the section called #phone_result 
                     // within the Bootstrap modal
                        $('#view_result').html(data);
                        // Display the Bootstrap modal
                        $('#viewModal').modal('show');
						
                    }
             });
             // End AJAX function	
			
         });
     });  
    </script>
	 <!-- EDIT MODAL -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title">Edit Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close">×</button>
        </div>
		  
        <!-- Place to print the fetched phone -->
         <div id="edit_result"></div>
		 
    </div>
	
  </div>
	
	<script type="text/javascript">
     // Start jQuery function after page is loaded
        $(document).ready(function(){
            $('.editBtn').click(function(){
				
            var id = $(this).attr('id');
                // Start AJAX function
				alert(id);
				
                $.ajax({
                 // Path for controller function which fetches selected phone data
                    url: "edit1.php",
                    // Method of getting data
                    method: "GET",
                    // Data is sent to the server
                    data: {id:id},
                    // Callback function that is executed after data is successfully sent and recieved
                    success: function(data){
                     // Print the fetched data of the selected phone in the section called #phone_result 
                     // within the Bootstrap modal
                        $('#edit_result').html(data);
                        // Display the Bootstrap modal
                        $('#editModal').modal('show');
                    }
             });
             // End AJAX function
         });
     });  
    </script>
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
 
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
</body>

</html>

