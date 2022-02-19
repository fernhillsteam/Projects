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
        <link rel="stylesheet" href="assets/css/nav.css">
        
        <!-- Modernizr -->
        <script src="assets/js/modernizr-2.6.2.min.js"></script>
		<style>
	

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
        </div><!-- /.navbar-main -->


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

					<h1 class="title-style-2">WHAT IS VTO<span class="title-under"></span></h1>

					<p>
						Vokkaliga (also transliterated as Vokkaligar, Vakkaliga, Wakkaliga, Okkaligar, Okkiliyan) is a community, or a group of closely-related castes, , from the Indian state of Karnataka. 
					</p>

					<p>
						They are also present in the neighbouring state of Tamil Nadu. As a community of warriors and cultivators they have historically had notable demographic, political, and economic 
					</p>

					<p>
						It is believed by some historians that the Rashtrakutas and Western Gangas were of Vokkaliga origin. The Vokkaligas occupied administrative positions.
					</p>

					<p>
						They later formed the early rulers of the Nayakas of Keladi .The Vokkaligas had the most families in the ruling classes of the 17th century when the Arasu caste of the Wodeyars was created to exclude them. 
					</p>

					<p>
						Under the Kingdom of Mysore they operated autonomously and also served in the army and militia. The Vokkaligas formed the landed-gentry and warrior class of Karnataka.

					</p>
					
				</div>

				<div class="col-md-6">

					<img src="assets/images/about-us.jpg" alt="" class="img-responsive">

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
                        <a href="#" class="btn btn-primary"> Read more </a>
                    
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
                        <a href="#" class="btn btn-primary"> Read more </a>
                    
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
                        <a href="#" class="btn btn-primary"> Read more </a>
                    
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


    

    <div class="section-home our-causes">

        <div class="container">

            <h2 class="title-style-1">About Us<span class="title-under"></span></h2>

            <div class="row">
			 <div class="col-md-3 col-sm-6">

                    <div class="cause">

                        <img src="assets/images/causes/3.png" alt="" class="cause-img">

                        <!-- <div class="progress cause-progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                            400$ / 1000$
                          </div>
                        </div> -->

                        <h4 class="cause-title"><a href="#">Background</a></h4>
                        <div class="cause-details">
                                Vokkaliga Trade Organisation (VTO), is a worldwide arganisation of Businessmen, industrialists, knowledge Workers and professionals from Vokkaliga community. 

                        </div>

                        <div class="btn-holder text-center">
                          <!-- Trigger the modal with a button -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#background">Read More</button>
                        </div>
						 <!-- Modal -->
                                  <div class="modal fade" id="background" tabindex="-1" role="dialog" aria-labelledby="donateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                           <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Background</h4>
                                          </div>
                                        <div class="modal-body">
                                         <p>Vokkaliga Trade Organisation (VTO), is a worldwide arganisation of Businessmen, industrialists, knowledge Workers and professionals from Vokkaliga community. </p>
										 <p>VTO came into existence after like minded business men amongst us came together in 2018 to facilitate and create a forum for all business men amongst our community.</p>
										 <p>VTO has been established with a plan strategy and to open avenues to solve issues of namma Community.</p>
									
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                       </div>
                                     </div>
                                 </div>
                             </div>

                        

                    </div> <!-- /.cause -->
                    
                </div>
                <div class="col-md-3 col-sm-6">

                    <div class="cause">

                        <img src="assets/images/causes/1.png" alt="" class="cause-img">

                        <!-- <div class="progress cause-progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                            10$ / 500$
                          </div>
                        </div> -->

                        <h4 class="cause-title"><a href="#">Vision & Mission</a></h4>
                        <div class="cause-details">
                        Vokkaliga Trade Organisation (VTOaspires) to become a World Class organization of all Vokkaliga Businessmen and professionals

                        </div>

                        <div class="btn-holder text-center">
                           <!-- Trigger the modal with a button -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vision">Read More</button>
                        </div>
						<!-- Modal -->
                                  <div class="modal fade" id="vision" tabindex="-1" role="dialog" aria-labelledby="donateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                           <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Vision & Mission</h4>
                                          </div>
                                        <div class="modal-body">
                                         <p>Vokkaliga Trade Organisation (VTO) aspires to become a World Class organization of all Vokkaliga Businessmen and professionals by promoting each other's business every second and by adding value to every single enterprise amongst us thereby benefitting one and all.</p>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                       </div>
                                     </div>
                                 </div>
                             </div>

                        

                    </div> <!-- /.cause -->
                    
                </div>


                <div class="col-md-3 col-sm-6">

                    <div class="cause">

                        <img src="assets/images/causes/3.png" alt="" class="cause-img">

                        <!-- <div class="progress cause-progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                            400$ / 1000$
                          </div>
                        </div> -->

                        <h4 class="cause-title"><a href="#">Objectives</a></h4>
                        <div class="cause-details">
                                VTO will be a worldwide organisation of businessmen, industrialists, knowledge workers and professionals from Vokkaliga community.

                        </div>

                        <div class="btn-holder text-center">
                          <!-- Trigger the modal with a button -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#objectives">Read More</button>
                        </div>
						 <!-- Modal -->
                                  <div class="modal fade" id="objectives" tabindex="-1" role="dialog" aria-labelledby="donateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                           <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Objectives</h4>
                                          </div>
                                        <div class="modal-body">
                                         <p>VTO will be a worldwide organisation of businessmen. industrialists, knowledge workers and professionals from Vokkaliga community</p>
										 <p>VTO is set to achieve socio-economic empowerment, value based education, community welfare, practice of compassion spread of global friendship.</p>
										 <p>VTO invites all Vokkaligas from the world over to become a united force as contributor, collaborator and co-workers for its objectives.</p>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                       </div>
                                     </div>
                                 </div>
                             </div>

                        

                    </div> <!-- /.cause -->
                    
                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="cause">

                        <img src="assets/images/causes/4.png" alt="" class="cause-img">

                        <!-- <div class="progress cause-progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                            400$ / 700$
                          </div>
                        </div> -->

                        <h4 class="cause-title"><a href="#">Society Goals</a></h4>
                        <div class="cause-details">
                                VTO would facilitate a Platform for young entrepreneurs for right business contacts and employment.
                        </div>

                        <div class="btn-holder text-center">
						  <!-- Trigger the modal with a button -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#society">Read More</button>
						</div>  
						  <!-- Modal -->
                                  <div class="modal fade" id="society" tabindex="-1" role="dialog" aria-labelledby="donateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                           <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Society Goals</h4>
                                          </div>
                                        <div class="modal-body">
                                         <p>VTO would facilitate a Platform for young entrepreneurs for right business contacts and employment.</p>
										 <p>Channelize united and systematic efforts towards creating a bright future for the youth including education sponsorship, loans etc.</p>
										 <p>Create platform for young entrepreneurs to interact and gain knowledge from the experienced and well established business leaders.</p>
										 <p>social programs with Emphasis on Education amongst Youngsters and Health fot all.</p>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                       </div>
                                     </div>
                                 </div>
                             </div>
                         
                          
                        </div>

                        

                    </div> <!-- /.cause -->
                    
                </div>

        </div>
        
    </div> <!-- /.our-causes -->



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

    </body>
</html>
