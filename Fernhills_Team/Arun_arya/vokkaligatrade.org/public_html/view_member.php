<?php
$id=$_GET['id'];

include 'db_connect.php';

?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Single cause | Charity / Non-profit responsive Bootstrap HTML5 template</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Dosis:400,700' rel='stylesheet' type='text/css'>

        <!-- Bootsrap -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">


        <!-- Font awesome -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- PrettyPhoto -->
        <link rel="stylesheet" href="assets/css/prettyPhoto.css">

        <!-- Template main Css -->
        <link rel="stylesheet" href="assets/css/style.css">
        
        <!-- Modernizr -->
        <script src="assets/js/modernizr-2.6.2.min.js"></script>


    </head>
    <body>
    <!-- NAVBAR
    ================================================== -->

    <header class="main-header">
        
    
        <nav class="navbar navbar-static-top">

            <div class="navbar-top">

              <div class="container">
                  <div class="row">

                    <div class="col-sm-6 col-xs-12">

                        <ul class="list-unstyled list-inline header-contact">
                            <li> <i class="fa fa-phone"></i> <a href="tel:">+212 658 986 213 </a> </li>
                             <li> <i class="fa fa-envelope"></i> <a href="mailto:contact@sadaka.org">contact@sadaka.org</a> </li>
                       </ul> <!-- /.header-contact  -->
                      
                    </div>

                    <div class="col-sm-6 col-xs-12 text-right">

                        <ul class="list-unstyled list-inline header-social">

                            <li> <a href="#" target="_blank"> <i class="fa fa-facebook"></i> </a> </li>
                            <li> <a href="#" target="_blank"> <i class="fa fa-twitter"></i>  </a> </li>
                            <li> <a href="#" target="_blank"> <i class="fa fa-google"></i>  </a> </li>
                            <li> <a href="#" target="_blank"> <i class="fa fa-youtube"></i>  </a> </li>
                            <li> <a href="#" target="_blank"> <i class="fa fa fa-pinterest-p"></i>  </a> </li>

                       </ul> <!-- /.header-social  -->
                      
                    </div>


                  </div>
              </div>

            </div>

            <div class="navbar-main">
              
              <div class="container">

                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                  </button>
                  
                  <a class="navbar-brand" href="index.html"><img src="assets/images/sadaka-logo.png" alt=""></a>
                  
                </div>

                <div id="navbar" class="navbar-collapse collapse pull-right">

                  <ul class="nav navbar-nav">

                    <li><a href="index.html">HOME</a></li>
                    <li><a href="about.html">ABOUT</a></li>
                    <li class="has-child "><a class="is-active" href="#">CAUSES</a>

                      <ul class="submenu">
                         <li class="submenu-item"><a href="causes.html">Causes list </a></li>
                         <li class="submenu-item"><a href="causes-single.html">Single cause </a></li>
                         <li class="submenu-item"><a href="causes-single.html">Single cause </a></li>
                         <li class="submenu-item"><a href="causes-single.html">Single cause </a></li>
                      </ul>

                    </li>
                    <li><a href="gallery.html">GALLERY</a></li>
                    <li><a href="contact.html">CONTACT</a></li>

                  </ul>

                </div> <!-- /#navbar -->

              </div> <!-- /.container -->
              
            </div> <!-- /.navbar-main -->


        </nav> 

    </header> <!-- /. main-header -->


	<div class="page-heading text-center">

		<div class="container zoomIn animated">
			
			<h1 class="page-title">MEMBER <span class="title-under"></span></h1>
			<p class="page-description">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit Necessitatibus.
			</p>
			
		</div>

	</div>

	<div class="main-container">
<?php
  
// SQL query to select data from database
$sql = "SELECT * FROM tbl_users  WHERE id = $id";
$result = $mysqli->query($sql);

?>
		<div class="container">

			<div class="row">

				<div class="col-md-2 col-sm-6">

					<h2 class="title-style-2"> Member Detail <span class="title-under"></span></h2>

			        <?php   // LOOP TILL END OF DATA 
                while($rows=$result->fetch_assoc())
                {
             ?>

	                    <div class="team-member">

	                        <div class="thumnail">

	                            <img src="assets/images/team/member-2.jpg" alt="" class="cause-img">
	                            
	                        </div>



	                        <h4 class="member-name"><a href="#"><?php echo $rows['name'];?></a></h4>

	                        <div class="member-position">
							<?php

                if($rows['designation'] == '1'){?>
                      Prime
                <?php }elseif($rows['designation'] == '2'){?>
                      Mentor
                  
                <?php }elseif($rows['designation'] == '3'){?>
                      Vice President

                <?php } 
				   
		?>
	                        </div>


	                        

	                    </div> <!-- /.team-member -->
	                    

			                  
			                

				</div>

				<div class="col-md-5">

					<h2 class="title-style-2"><br></h2>				 
			         <div class="row">
                    <div class="col-sm-4">
                      Name
                    </div>
                    <div class="col-sm-8">
                      <?php echo $rows['name'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                     User Name
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <?php echo $rows['username'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      Email Adress
                    </div>
                    <div class="col-sm-8 text-secondary">
                     <?php echo $rows['email'];?> 
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      Mobile
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <?php  echo $rows['mobile']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    
	

			  <?php

                if( $rows['roleid'] == '1'){?>
				    <div class="col-sm-4">
                     Role
                    </div>
                    <div class="col-sm-8 text-secondary">
                      Admin
                    </div>
                
                <?php }elseif($rows['roleid'] == '2'){?>
                    <div class="col-sm-4">
                     Role
                    </div>
                    <div class="col-sm-8 text-secondary">
                      Editor
                    </div>
                  
                <?php }elseif($rows['roleid'] == '3'){?>
                     <div class="col-sm-4">
                     Role
                    </div>
                    <div class="col-sm-8 text-secondary">
                      User
                    </div>


                <?php } 
				   
					
				?>
		   
		   </div>
		   <hr>
                  <div class="row">
                    
	

			  <?php

                if($rows['designation'] == '1'){?>
				    <div class="col-sm-4">
                      Designation
                    </div>
                    <div class="col-sm-8 text-secondary">
                      Prime
                    </div>
                
                <?php }elseif($rows['designation'] == '2'){?>
                    <div class="col-sm-4">
                  >Designation
                    </div>
                    <div class="col-sm-8 text-secondary">
                      Mentor
                    </div>
                  
                <?php }elseif($rows['designation'] == '3'){?>
                     <div class="col-sm-4">
                     Designation
                    </div>
                    <div class="col-sm-8 text-secondary">
                      Vice President
                    </div>


                <?php } 
				   
		?>
		   
		   </div>
                  
				</div>

     <?php
                }
             ?>
			 
			 
<?php
  
// SQL query to select data from database
$sql = "SELECT * FROM business  WHERE user_id = $id";
$result = $mysqli->query($sql);
?>			 
  <?php   // LOOP TILL END OF DATA 
                while($rows=$result->fetch_assoc())
                {
             ?>
			 <div class="col-md-5">

					<h2 class="title-style-2"><br></h2>					 
			         <div class="row">
                    <div class="col-sm-4">
                      Business
                    </div>
                    <div class="col-sm-8">
                      <?php echo $rows['business'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                     Business type
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <?php echo $rows['biztype'];?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      Business Desciption
                    </div>
                    <div class="col-sm-8 text-secondary">
                     <?php echo $rows['description'];?> 
                    </div>
                  </div>
                  
			
				</div>
			 
			
			 
			</div>
       
        <br><br>
		<div class="row">

				<div class="col-md-2 col-sm-6">

	                    <div class="team-member">

	                        <div class="thumnail">

	                            <img src="login/business/<?php echo $rows['logo'];?>" alt="" class="cause-img">
	                            
	                        </div>
	                        <h4 class="member-name"><a href="#">LOGO</a></h4>

	                     


	                 
	                    </div> <!-- /.team-member -->
	                    

		
   

				</div>
				
     <?php
                }
             ?>

<?php
  
// SQL query to select data from database
$sql = "SELECT * FROM biz_images WHERE user_id = $id";
$result = $mysqli->query($sql);
?>
              <div class="col-md-10 col-sm-6 " >
			  <div class="text-center" style="margin-bottom:10px;">
			  Business images
			  </div>
			    <div class="row">
				  <?php   // LOOP TILL END OF DATA 
		if ($result -> num_rows > 0)	{	  
                while($rows=$result->fetch_assoc())
                {
				
             ?>
	                <div class="col-md-3 col-sm-6" style="margin-bottom:20px;">

	                    <div class="team-member">

	                        <div class="thumnail">

	                            <img src="login/business/<?php echo $rows['image'];?>" alt="" class="cause-img">
	                            
	                        </div>


	                    </div> <!-- /.team-member -->
						
	                    
	                </div>

	                <?php
	
				}}else{?>
				<div class="text-center">
				Not Uploaded
				</div>
				<?php
				}
				
				?>
	            </div> <!-- /.row -->
               </div>
			 
			</div>
		</div>

		
<div class="text-center">
		
 <a href="members.php" class="btn btn-primary"> Back </a>
 
</div> 

	</div> <!-- /.main-container  -->


    <footer class="main-footer">

        <div class="footer-top">
            
        </div>


        <div class="footer-main">
            <div class="container">
                
                <div class="row">
                    <div class="col-md-4">

                        <div class="footer-col">

                            <h4 class="footer-title">About us <span class="title-under"></span></h4>

                            <div class="footer-content">
                                <p>
                                    <strong>Sadaka</strong> ipsum dolor sit amet, consectetur adipiscing elit. Ut at eros rutrum turpis viverra elementum semper quis ex. Donec lorem nulla, aliquam quis neque vel, maximus lacinia urna.
                                </p> 

                                <p>
                                    ILorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at eros rutrum turpis viverra elementum semper quis ex. Donec lorem nulla, aliquam quis neque vel, maximus lacinia urna.
                                </p>

                            </div>
                            
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="footer-col">

                            <h4 class="footer-title">LAST TWEETS <span class="title-under"></span></h4>

                            <div class="footer-content">
                                <ul class="tweets list-unstyled">
                                    <li class="tweet"> 

                                        20 Surprise Eggs, Kinder Surprise Cars 2 Thomas Spongebob Disney Pixar  http://t.co/fTSazikPd4 

                                    </li>

                                    <li class="tweet"> 

                                        20 Surprise Eggs, Kinder Surprise Cars 2 Thomas Spongebob Disney Pixar  http://t.co/fTSazikPd4 

                                    </li>

                                    <li class="tweet"> 

                                        20 Surprise Eggs, Kinder Surprise Cars 2 Thomas Spongebob Disney Pixar  http://t.co/fTSazikPd4 

                                    </li>

                                </ul>
                            </div>
                            
                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="footer-col">

                            <h4 class="footer-title">Contact us <span class="title-under"></span></h4>

                            <div class="footer-content">

                                <div class="footer-form" >
                                    
                                    <form action="php/mail.php" class="ajax-form">

                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                                        </div>

                                         <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                                        </div>

                                        <div class="form-group">
                                            <textarea name="message" class="form-control" placeholder="Message" required></textarea>
                                        </div>

                                        <div class="form-group alerts">
                        
                                            <div class="alert alert-success" role="alert">
                                              
                                            </div>

                                            <div class="alert alert-danger" role="alert">
                                              
                                            </div>
                                            
                                        </div>

                                         <div class="form-group">
                                            <button type="submit" class="btn btn-submit pull-right">Send message</button>
                                        </div>
                                        
                                    </form>

                                </div>
                            </div>
                            
                        </div>

                    </div>
                    <div class="clearfix"></div>



                </div>
                
                
            </div>

            
        </div>

        <div class="footer-bottom">

            <div class="container text-right">
                Sadaka @ copyrights 2015 - by <a href="http://www.ouarmedia.com" target="_blank">Ouarmedia</a>
            </div>
        </div>
        
    </footer>




       
        
        <!-- jQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/jquery-1.11.1.min.js"><\/script>')</script>

        <!-- Bootsrap javascript file -->
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- PrettyPhoto javascript file -->
        <script src="assets/js/jquery.prettyPhoto.js"></script>



        <!-- Google map  -->
        <script src="http://maps.google.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>


        <!-- Template main javascript -->
        <script src="assets/js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>
