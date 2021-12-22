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
$userid = Session::get('id');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_pic'])) {
  $updateImage = $users->updateImgByUser($userid);

}

if (isset($updateImage)) {
  echo $updateImage;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['biz_image'])) {
  $updateBizImage = $users->updateBizImgByUser($userid, $_POST);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['biz_detail'])) {
  $updateBizDetail = $users->updateUserBizByUser($userid, $_POST);

}

if (isset($_GET['removeimg'])) {
	
  $removeimg = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['removeimg']);
  
  $removeImg = $users->deleteUserImgByUser($removeimg);
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
   VTO Member Dashboard
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<style>

.avatar-upload {
  position: relative;
  max-width: 205px;
  margin: 50px auto;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 34px;
  height: 34px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #ffffff;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: "FontAwesome";
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 192px;
  height: 192px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #f8f8f8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}


.img-thumb {
  max-height: 75px;
  border: 2px solid none;
   border-radius:3px;
  padding: 1px;
  cursor: pointer;
}
.img-thumb-wrapper {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid none;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
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
         <strong> VTO </strong>
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
           <li class="active ">
		  <a href="./dashboard.php">
			<i> <img src="../assets/icons/editprofile.png"></i>
              <p><strong>Edit Profile</strong></p>
            </a>
          </li>
          <li>
            <a href="#">
			  <i> <img src="../assets/icons/meeting.png"></i>
              <p><strong>Manage Meetings</strong></p>
            </a>
          </li>

          <li>
            <a href="#">
			  <i> <img src="../assets/icons/businessman.png"></i>
              <p><strong>Business Referrals</strong></p>
            </a>
          </li>
          <li >
            <a href="?action=userlogout">
              <i> <img src="../assets/icons/logout.png"></i>
              <p><strong>log out</strong></p>
            </a>
          </li>

          <li class="active-pro">
            <a href="">
			
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
            <a class="navbar-brand" href="javascript:;"><strong>Edit Profile</strong></a>
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
                  <a class="dropdown-item" href="?action=userlogout">Logout</a>

                </div>
            </li>
            
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <!--<p class="category"><b>edit profile tabs</b></p>-->
      <!-- Nav tabs -->
      <div class="card">
        <div class="card-header">
         <ul class="nav nav-tabs justify-content-left" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                <i class="now-ui-icons objects_umbrella-13"></i> Profile
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
                <i class="now-ui-icons shopping_cart-simple"></i> Business Profile
              </a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="home" role="tabpanel">
			<div class="row">
      <!-- left column -->
	  		  <?php
    $getUinfo = $users->getUserInfoById($userid);
    if ($getUinfo) {

     ?>		  
      <div class="col-md-3">
       <div class="container">
	   <form action="" method="POST"  enctype="multipart/form-data"> 
    <div class="avatar-upload">
        <div class="avatar-edit">
            <input type='file' id="imageUpload" name="profile" accept=".png, .jpg, .jpeg" />
            <label for="imageUpload"></label>
        </div>
		<?php
	      if($getUinfo->profile == null){
			  ?>
        <div class="avatar-preview">
            <div id="imagePreview" style="background-image: url('../assets/images/profile.png');">
            </div>
        </div>
		<?php
		  }else{		  
		     ?>
			 <div class="avatar-preview">
            <div id="imagePreview" style="background-image: url('../profile/<?php echo $getUinfo->profile; ?>');">
            </div>
        </div>
		<?php }
		  ?>
		 <br>
			<h6 class="text-center">Profile Pic</h6> 
           <button name="upload_pic" type="submit" class="btn btn-primary" style="margin-left:50px;">Upload</button>	  
	 			
		
    </div>
	</form>
</div>
      </div>
      
      <!-- edit form column -->
	  <div class="col-md-9">					 
			         <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $getUinfo->name; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">User Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $getUinfo->username; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email Adress</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $getUinfo->email; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $getUinfo->mobile; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    
	

			  <?php

                if($getUinfo->roleid == '1'){?>
				    <div class="col-sm-3">
                      <h6 class="mb-0">Role</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Admin
                    </div>
                
                <?php }elseif($getUinfo->roleid == '2'){?>
                    <div class="col-sm-3">
                      <h6 class="mb-0">Role</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Editor
                    </div>
                  
                <?php }elseif($getUinfo->roleid == '3'){?>
                     <div class="col-sm-3">
                      <h6 class="mb-0">Role</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      User
                    </div>


                <?php } 
				   
					
				?>
		   
		   </div>
		   <hr>
                  <div class="row">
                    
	

			  <?php

                if($getUinfo->designation == '1'){?>
				    <div class="col-sm-3">
                      <h6 class="mb-0">Designation</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Prime
                    </div>
                
                <?php }elseif($getUinfo->designation == '2'){?>
                    <div class="col-sm-3">
                      <h6 class="mb-0">Designation</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Mentor
                    </div>
                  
                <?php }elseif($getUinfo->designation == '3'){?>
                     <div class="col-sm-3">
                      <h6 class="mb-0">Designation</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Vice President
                    </div>


                <?php } 
				   
	}	?>
		   
		   </div>
                  
                  
			</div>
     
  </div>
 
			
            </div>
			
            <div class="tab-pane" id="profile1" role="tabpanel">

 
 <div class="row">
          <div class="col-md-12">
          
              <!--<div class="card-header">
                <h5 class="card-title">Notifications</h5>
                <p class="card-category">Handcrafted by our friend <a target="_blank" href="https://github.com/mouse0270">Robert McIntosh</a>. Please checkout the <a href="http://bootstrap-notify.remabledesigns.com/" target="_blank">full documentation.</a></p>
              </div>-->
              <div class="card-body">
                <div class="row">
		
                  <div class="col-md-3">
                    <div class="card card-plain">
                      <div class="card-header">
                        <h5 class="card-title">Business</h5>
                      </div>
                      <div class="card-body">
                        <div class="container">
			<?php
    $getBinfo = $users->getBizInfoById($userid);
    if ($getBinfo) {

     ?>					
    <div class="avatar-upload">
        <div class="avatar-edit">
		<form action="" method="POST"  enctype="multipart/form-data"> 
            <input type='file' id="logoUpload" name="logo" accept=".png, .jpg, .jpeg" />
            <label for="logoUpload"></label>
        </div>
		<?php
	      if($getBinfo->logo == null){
			  ?>
        <div class="avatar-preview">
            <div id="logoPreview" style="background-image: url('../assets/images/profile.png');">
            </div>
        </div>
		<?php
		  }else{		  
		     ?>
			 <div class="avatar-preview">
            <div id="logoPreview" style="background-image: url('../profile/<?php echo $getBinfo->logo; ?>');">
            </div>
        </div>
		<?php }
		  ?>
		 <br>
			<h6 class="text-center">Logo</h6> 
    </div>
</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="card card-plain">
                      <div class="card-header">
                        <!--<h5 class="card-title">Notification states</h5>-->
                      </div>
                      <div class="card-body">
					     <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Business</label>
      <input type="text" class="form-control" id="inputCity" name="business" placeholder="Business" value="<?php echo $getBinfo->business; ?>">
    </div>
	<div class="form-group col-md-6">
      <label for="inputEmail4">Business Type</label>
      <input type="text" class="form-control" id="inputEmail4" name="biztype" placeholder="Business Type" value="<?php echo $getBinfo->biztype; ?>">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputPassword4">Business description</label>
      <textarea type="email" class="form-control" id="inputPassword4" name="description" placeholder="Business description"><?php echo $getBinfo->description; ?></textarea>
    </div>
   </div>
   <button name="biz_detail" type="submit" class="btn btn-primary">Submit</button>
</form>
<?php 
	
	} ?> 
    <form action="" method="POST"  enctype="multipart/form-data">
	<div class="form-row">
	
	   <div class="col-md-4">
      <label for="inputPassword4">Business Images</label>
	  <input type="file" name="image[]" class="form-control"  multiple/>
	</div>  
	<div class=" form-group col-md-2">
	
	   <button name="biz_image" type="submit" class="btn btn-success" style="margin-top:24px;margin-left:20px">Add</button>
     </div>
	
	</div>
	 </form>
	 <div class="container">
    <div class="row">
				<?php
				
				      $allImg = $users->selectAllBizImg($userid);
                          if ($allImg) {
                       
                        foreach ($allImg as  $value) {				
				?>
				<div class='col-md-3'>
                        <img class="img-responsive" alt="" src="../business/<?php echo $value->image; ?>" />
                    <form action="/imageDelete.php" method="POST">
					<a href="?removeimg=<?php echo $value->sl_no;?>" >delete</a>
                    </form>
                </div> <!-- col-6 / end -->
    
                  <?php
				  
						}
						  }?>		

    </div> <!-- row / end -->
</div> <!-- container / end -->
</div>
       
   </div>
					  
					               </div>						   
								   
                  </div>
                </div>
              
            </div>
          </div>
		  
			</div>
			</div>
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





  <!--   Core JS Files   -->



  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.jqueryui.min.js"></script>
  <script>
      function imagePreview(fileInput) {
    if (fileInput.files && fileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (event) {
            $('#preview').html('<img src="'+event.target.result+'" width="200" height="auto"/>');
        };
        fileReader.readAsDataURL(fileInput.files[0]);
    }
}

$("#image").change(function () {
    imagePreview(this);
});
   </script>
    
	<!--Profile image-->
	<script>
	  function readImgURL(input) {
		  
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readImgURL(this);
});
	</script>
	
	<!--Profile image-->
	<script>
	  function readlogoURL(input) {
		  
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#logoPreview').css('background-image', 'url('+e.target.result +')');
            $('#logoPreview').hide();
            $('#logoPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#logoUpload").change(function() {
    readlogoURL(this);
});
	</script>
	
	<script>
	$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<div class=\"img-thumb-wrapper card shadow\">" +
            "<img class=\"img-thumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove</span>" +
            "</div>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".img-thumb-wrapper").remove();
          });
          
        });
        fileReader.readAsDataURL(f);
      }
      console.log(files);
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
	</script>

   <script>
    $(document).ready(function(){
    $('#tableList').DataTable();
	console.log("hello");
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
