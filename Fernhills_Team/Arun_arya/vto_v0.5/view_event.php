<?php
$id=$_GET['id'];

include 'db_connect.php';

?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>VTO</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Dosis:400,700' rel='stylesheet' type='text/css'>

        <!-- Bootsrap -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- Font awesome -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- Owl carousel -->
        <link rel="stylesheet" href="assets/css/owl.carousel.css">

        <!-- Template main Css -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		 <!-- Nav Css -->
        <link rel="stylesheet" href="assets/css/slicknav.min.css">
		
		 <!-- Footer Css -->
        <link rel="stylesheet" href="assets/css/footer.css">
        
        <!-- Modernizr -->
        <script src="assets/js/modernizr-2.6.2.min.js"></script>
        <style>
     .header img {
  float: left;
  width: 61px;
  height: 61px;
  background: transparent;
}

.header span {
  position: relative;
  top: 19px;
  left: 5px;
  font-size: 18px;
}


 </style>

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
                            <li> <i class="fa fa-phone"></i> <a href="tel:" style="text-decoration: none;">+91 9876543210</a> </li>
                             <li> <i class="fa fa-envelope"></i> <a href="mailto:contact@sadaka.org" style="text-decoration: none;">contact@vto.org</a> </li>
                       </ul> <!-- /.header-contact  -->
                      
                    </div>

                    <div class="col-sm-6 col-xs-12 text-right">

                        <ul class="list-unstyled list-inline header-social">
                          
                            <li><a class="is-active" href="login/page/login.php" style="text-decoration: none;">LOGIN</a></li>
                            <li><a class="is-active" href="#" style="text-decoration: none;">BECOME A MEMBER</a></li>
                            <li> <a href="#"> <i class="fa fa-facebook"></i> </a> </li>
                            <li> <a href="#"> <i class="fa fa-twitter"></i>  </a> </li>
                            <li> <a href="#"> <i class="fa fa-google"></i>  </a> </li>
                            <li> <a href="#"> <i class="fa fa-youtube"></i>  </a> </li>
                            <li> <a href="#"> <i class="fa fa fa-pinterest-p"></i>  </a> </li>
                       </ul> <!-- /.header-social  -->
                      
                    </div>



                  </div>
              </div>

            </div>
	<div id="main_menu" class="main_menu">
            <div class="logo_area">
                <a href=""><img src="assets/images/vto.png" alt="" class="logo"></a>
            </div>
            <div class="inner_main_menu">
                <ul id="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="members.php">Members</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                </ul>
            </div>
        </div>
	       <nav id="mobilemenu"></nav>
        </nav> 

    </header> <!-- /. main-header -->


	<div class="page-heading text-center">

		<div class="container zoomIn animated">
			
			<h1 class="page-title">EVENT DETAILS <span class="title-under"></span></h1>
			<!-- <p class="page-description">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit Necessitatibus.
			</p> -->
			
		</div>

	</div>

	<div class="main-container">

		<div class="container">

			<div class="row fadeIn animated">

				<div class="col-md-6">

					<img src="assets/images/event.jpeg" alt="" class="img-responsive">

				</div>
<?php
  
// SQL query to select data from database
$sql = "SELECT * FROM events1  WHERE id = $id";
$result = $mysqli->query($sql);

?>
				<div class="col-md-6">

					<h2 class="title-style-2">Event Details<span class="title-under"></span></h2>
     <?php   // LOOP TILL END OF DATA 
                while($rows=$result->fetch_assoc())
                {  
             ?>
					<p>
						Title : <?php echo $rows['title'];?>
					</p>
                    <p>
                        Venue : <?php echo $rows['venue'];?>
                    </p>

                    <p>
                        Description : <?php echo $rows['description'];?>
                    </p>

					<p>
						Date : <?php echo $rows['start_date'];?>
					</p>
					
                    <p>
						Fee : <?php echo $rows['efee'];?> RS
					</p>
					
					 <?php
                }
             ?>

                <div class="text-center">
        
 <a href="events.php" class="btn btn-primary"> Back </a>
 
</div>

				</div>

			</div> <!-- /.row -->

			

		</div> <!-- /.about-us -->
		


	</div>


 <footer class="main-footer">

    <div class="footer mx-5">
        <div class="row mb-4 ">
            <div class="col-md-4 col-sm-11 col-xs-11">
                <div class="footer-text pull-left">
                    <div class="d-flex">
                        <h1 class="font-weight-bold mr-2 px-3" >VTO</h1>
                    </div>
                    <p class="card-text">Vokkaliga Trade Organisation (VTO) aspires to become a World Class organization of all Vokkaliga Businessmen and professionals</p>
                    <div class="social mt-2 mb-3"> <i class="fa fa-facebook-official fa-lg"></i> <i class="fa fa-instagram fa-lg"></i> <i class="fa fa-twitter fa-lg"></i></div>
                </div>
            </div>
            <div class="col-md-2 col-sm-1 col-xs-1 mb-2"></div>
            <div class="col-md-2 col-sm-4 col-xs-4">
                <h5 class="heading">Services</h5>
                <ul>
                    <li>IT Consulting</li>
                    <li>Development</li>
                    <li>Cloud</li>
                    <li>DevOps & Support</li>
                </ul>
            </div>
             <div class="col-md-2 col-sm-1 col-xs-1 mb-2"></div>
            <div class="col-md-2 col-sm-4 col-xs-4">
                <h5 class="heading">Company</h5>
                <ul class="card-text">
                    <li>About Us</li>
                    <li>Blog</li>
                    <li>Contact</li>
                    <li>Join Us</li>
                </ul>
            </div>
        </div>
        <div class="divider mb-4"> </div>
		<br>
        <div class="row" style="font-size:15px;">
            <div class="col-auto">
                <div class="copyright text-center">
                    <p>Vokkaligara Trade Organisation <i class="fa fa-copyright"></i> 2020 - by <a href="http://fernhilltechnologies.com/" target="_blank">Fernhill Technologies</a></p>
                </div>
            </div>
          <!--  <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="pull-right mr-4 d-flex policy">
                    <div>Terms of Use</div>
                    <div>Privacy Policy</div>
                    <div>Cookie Policy</div>
                </div>
            </div>-->
        </div>
    </div>

        
        
    </footer> <!-- main-footer -->




       
        
        <!-- jQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/jquery-1.11.1.min.js"><\/script>')</script>

        <!-- Bootsrap javascript file -->
        <script src="assets/js/bootstrap.min.js"></script>


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
		<script src="assets/js/jquery.slicknav.min.js"></script>
   		<script type="text/javascript">
    	$(document).ready(function(){
			$('.inner_main_menu').slicknav({prependTo:"#mobilemenu"});
    	});
    	</script>
    </body>
</html>
