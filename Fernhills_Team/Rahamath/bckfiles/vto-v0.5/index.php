<?php
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
	     p{
            text-align: justify;
         }

		</style>

    </head>

    <body>

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




    <!-- Carousel
    ================================================== -->
	<?php
  
// SQL query to select data from database
$sql = "SELECT * FROM slider_images ORDER BY sl_no DESC";
$result = $mysqli->query($sql);
?>

<div id="homeCarousel" class="carousel slide carousel-home" data-ride="carousel">

          <!-- Indicators -->
		  <ol class="carousel-indicators">
         <?php
		 
               $i=0;
			   
                    while($rows=$result->fetch_assoc())
                {
                      if($i==0){
                               ?>
				
							   <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
							   <?php
                                $i++;
                               }
                          else
                            {
							?>    
								<li data-target="#homeCarousel" data-slide-to="0"></li>
							
								<?php
                                  $i++;
                           }
                }
			
    ?>
          </ol>
<?php
  
// SQL query to select data from database
$sql = "SELECT * FROM slider_images ORDER BY sl_no DESC";
$result = $mysqli->query($sql);
?>
		  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
      <?php
               $a=0;
                 while($sliders=$result->fetch_assoc())
                {
                                       if($a==0){
                ?>
				<div class="item active"><img src="assets/images/slider/<?php echo $sliders['slider']; ?>" alt="..."></div>
				
				<?php
			
                $a++;
            }
            else
            {
               ?>
			   <div class="item"><img src="assets/images/slider/<?php echo $sliders['slider']; ?>" alt="..."></div>
			   <?php
                $a++;
            }
        }
    
    ?>
  </div>
  
         

          <a class="left carousel-control" href="#homeCarousel" role="button" data-slide="prev">
            <span class="fa fa-angle-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>

          <a class="right carousel-control" href="#homeCarousel" role="button" data-slide="next">
            <span class="fa fa-angle-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>

    </div>
	  <!-- /.carousel -->
	  
	<!-- The App Section -->
	<div class="section-home about-us fadeIn animated">
        <div class="container">
	<div class="row">
	
	            <div class="col-md-6">

					<h1 class="title-style-2">What is VTO<span class="title-under"></span></h1>

					<p style="line-height: 1.0cm;">
						VTO is an organization  passionately focused on networking & professional development  amongst businesses run by vokkaliga gowda businessmen  and we take pride in stating that there are various leaders who have achieved great heights by working together in businesses. 
					</p>

					<p style="line-height: 1.2cm;">
						VTO  is a service  organisation passionately focused on the professional development and success of our members.
					</p>

					<p style="line-height: 1.2cm;">
						When you join VTO, you will receive access to an exclusive privelege club of professionals.
					</p>
					
				</div>

				<div class="col-md-6">

					<img src="assets/images/about.png" alt="" class="img-responsive">

				</div>

				

			</div> <!-- /.row -->
			
	</div>
      
    </div>		

    <!-- The App Section -->
    <div class="section-home about-us fadeIn animated">
        <div class="container">
    <div class="row">
                 <div class="col-md-6">

                    <img src="assets/images/formed.jpg" alt="" class="img-responsive">

                </div>
    
                <div class="col-md-6">

                    <h1 class="title-style-2">How VTO Was formed<span class="title-under"></span></h1>

                    <p>
                        Vokkaliga Trade Organisation (VTO) as it is known is networking platform for businessmen of the Vokkaliga gowda community. 
                    </p>

                    <p>
                       VTO was conceptualized with a vision to network fellow businessmen and promote intra community business amongst the Vokkaliga trade organisation and promote mutual business and goodwill and develop bonhomieship amongst members of the community.
                    </p>

                    <p>
                       VTO was conceptualized in a casual Ugadi talk and took off with our directors deciding to unite one and all businesses amongst its members.It is one of its kind organisation of the Vokkaliga gowda community.
                    </p>

                    <p>
                        Today VTO is one of its kind in its league of business networking and find mention by one and all for business networking amongst the Vokkaliga Gowda community. A formal relationship is usually the beginning and our members through their relationships build business and solidly network with co members.
                    </p>

                    <p>
                        Meeting over a buffet or in a one to one meeting and exchanging ideas and contacts to mutually grow business is the best ways to grow and time tested method and by leveraging the vast set of network, you stand to gain by improving your business velocity and accelerate business growth.
                    </p>
                    
                </div>

               

                

            </div> <!-- /.row -->
            
    </div>
      
    </div>

    <div class="section-home about-us fadeIn animated">

        <div class="container">

            <div class="row">

                <div class="col-md-4 col-sm-6">
                
                  <div class="about-us-col">

                        <div class="col-icon-wrapper">
                          <img src="assets/images/icons/our-mission-icon.png" alt="">
                        </div>
                        <h3 class="col-title">our mission</h3>
                        <div class="col-details">

                          <p>VTO would facilitate a Platform for young entrepreneurs for right business contacts and employment.
                            Promote Young Gowdas</p>
                          
                        </div>
                        <a href="about.php" class="btn btn-primary"> Read more </a>
                    
                  </div>
                  
                </div>


                <!-- <div class="col-md-3 col-sm-6">
                
                  <div class="about-us-col">

                        <div class="col-icon-wrapper">
                          <img src="assets/images/icons/make-donation-icon.png" alt="">
                        </div>
                        <h3 class="col-title">Make donations</h3>
                        <div class="col-details">

                          <p>Lorem ipsum dolor sit amet consect adipisscin elit proin vel lectus ut eta esami vera dolor sit amet consect</p>
                          
                        </div>
                        <a href="#" class="btn btn-primary"> Read more </a>
                    
                  </div>
                  
                </div> -->


                <div class="col-md-4 col-sm-6">
                
                  <div class="about-us-col">

                        <div class="col-icon-wrapper">
                          <img src="assets/images/icons/help-icon.png" alt="">
                        </div>
                        <h3 class="col-title">Help & support</h3>
                        <div class="col-details">

                          <p>VTO would facilitate a Platform for young entrepreneurs for right business contacts and employment.
                            Promote Young Gowdas</p>
                          
                        </div>
                        <a href="contact.php" class="btn btn-primary"> Read more </a>
                    
                  </div>
                  
                </div>


                <div class="col-md-4 col-sm-6">
                
                  <div class="about-us-col">

                        <div class="col-icon-wrapper">
                          <img src="assets/images/icons/programs-icon.png" alt="">
                        </div>
                        <h3 class="col-title">our programs</h3>
                        <div class="col-details">

                          <p>VTO would facilitate a Platform for young entrepreneurs for right business contacts and employment.
                            Promote Young Gowdas</p>
                          
                        </div>
                        <a href="events.php" class="btn btn-primary"> Read more </a>
                    
                  </div>
                  
                </div>
                

                
            </div>

        </div>
      
    </div> <!-- /.about-us -->

    <!-- <div class="section-home home-reasons">

        <div class="container">

            <div class="row">
                
                <div class="col-md-6">

                    <div class="reasons-col animate-onscroll fadeIn">

                        <img src="assets/images/reasons/we-fight-togother.jpg" alt="">

                        <div class="reasons-titles">

                            <h3 class="reasons-title">We fight together</h3>
                            <h5 class="reason-subtitle">We are humans</h5>
                            
                        </div>

                        <div class="on-hover hidden-xs">
                            
                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur praesentium, itaque facilis nesciunt ab omnis cumque similique ipsa veritatis perspiciatis, harum ad at nihil molestias, dignissimos sint consequuntur. Officia, fuga.</p>


                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur praesentium, itaque facilis nesciunt ab omnis cumque similique ipsa veritatis perspiciatis, harum ad at nihil molestias, dignissimos sint consequuntur. Officia, fuga.</p>

                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur praesentium, itaque facilis nesciunt ab omnis cumque similique ipsa veritatis perspiciatis, harum ad at nihil molestias, dignissimos sint consequuntur. Officia, fuga.</p>
                                
                        </div>
                    </div>
                    
                </div>


                <div class="col-md-6">

                    <div class="reasons-col animate-onscroll fadeIn">

                        <img src="assets/images/reasons/we-care-about.jpg" alt="">

                        <div class="reasons-titles">

                            <h3 class="reasons-title">WE care about others</h3>
                            <h5 class="reason-subtitle">We are humans</h5>
                            
                        </div>

                        <div class="on-hover hidden-xs">
                            
                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur praesentium, itaque facilis nesciunt ab omnis cumque similique ipsa veritatis perspiciatis, harum ad at nihil molestias, dignissimos sint consequuntur. Officia, fuga.</p>


                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur praesentium, itaque facilis nesciunt ab omnis cumque similique ipsa veritatis perspiciatis, harum ad at nihil molestias, dignissimos sint consequuntur. Officia, fuga.</p>

                                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur praesentium, itaque facilis nesciunt ab omnis cumque similique ipsa veritatis perspiciatis, harum ad at nihil molestias, dignissimos sint consequuntur. Officia, fuga.</p>
                                
                        </div>


                    </div>
                    
                </div>


            </div>
          
  

        </div>
      

    </div> --> <!-- /.home-reasons -->





    <footer class="main-footer">

    <div class="footer mx-5">
        <div class="row">
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









    <!--  Scripts
    ================================================== -->

    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery-1.11.1.min.js"><\/script>')</script>

    <!-- Bootsrap javascript file -->
    <script src="assets/js/bootstrap.min.js"></script>
    
    <!-- owl carouseljavascript file -->
    <script src="assets/js/owl.carousel.min.js"></script>

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
