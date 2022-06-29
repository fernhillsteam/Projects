<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>
    Pendios
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
    
</head>
<body>
<?php   
   require('db.php');
	

 function fill_user($con)  
 {  
      $output = '';  
      $query ="SELECT `id`,`device_id` FROM `usersp`"; 
      $result = mysqli_query($con,$query);  
      while($row = mysqli_fetch_array($result))  
      {  
             $output .= '<option value="'.$row["id"].'">'.$row["device_id"].' </option>';  
      
      }  
      return $output;  
 }  
//function fill_device($con)  
// {  
  //    $output = '';  
    //  $query =  "SELECT * FROM `usersp` " ;  
      //$result = mysqli_query($con,$query);  
      //while($row = mysqli_fetch_array($result))  
      //{  
        //   $output .= '<div class="col-md-3">';  
         //  $output .= '<div style="border:1px solid #ccc; padding:20px; margin-bottom:20px;">Device ID:'.$row["device_id"].'';  
           //$output .=     '</div>';  
           //$output .=     '</div>';  
      //}  
      //return $output;  
 //}  
 
 ?>
<div class="row">
	 <div class="col-md-12">
	
	  <div class="card">
              <div class="card-header">
               <h4 class="card-title">Select Device</h4>
              <div class="card-body">
                <div class="row">
		  <form class="col-md-12">
		   <select class="form-control select2" name="userId" id="user">  
                          <option value="">Device ID</option>  
                          <?php echo fill_user($con); ?>  
           </select> 
      </form>
  </div>
				</div>
			  </div>
       </div>
    </div>
</div>	

                    <div class="" id="device">  
                      
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
    
 
 <script src="bootstrap-4.0.0/dist/js/bootstrap.js"></script>
 <script src="../assets/js/core/bootstrap.min.js"></script>
</body>
</html>