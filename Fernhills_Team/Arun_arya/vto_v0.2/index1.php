<?php
include_once 'classes/Website.php';
$website = new Website();
 ?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>vto</title>
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

            <div class="navbar-main">
              
              <div class="container">

                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                  </button>
                  <div class="header">
                      <a href="http://vokkaligatrade.org/index.html" style="text-decoration: none;">
                          <img src="assets/images/VTO.png" alt="logo" /></a>
                   <span>Vokkaliga Trade Organisation</span>
                   </div>
                </div>

                <div id="navbar" class="navbar-collapse collapse pull-right">

                  <ul class="nav navbar-nav">

                    <li><a class="is-active" href="index.php">HOME</a></li>
                    <li><a href="about.html">ABOUT US</a></li>
                    <li class="has-child"><a href="events.php">EVENTS</a>

                      <ul class="submenu">
                        <li class="submenu-item"><a href="#">Event 1 </a></li>
                         <li class="submenu-item"><a href="#">Event 2 </a></li>
                         <li class="submenu-item"><a href="#">Event 3 </a></li>
                         <li class="submenu-item"><a href="#">Event 4 </a></li>
                      </ul>

                    </li>
                    <li><a href="gallery.html">GALLERY</a></li>
                    <li><a href="members.php">MEMBERS</a></li>
                    <li><a href="contact.html">CONTACT US</a></li>

                  </ul>

                </div> <!-- /#navbar -->

              </div> <!-- /.container -->
              
            </div> <!-- /.navbar-main -->


        </nav> 

    </header> <!-- /. main-header -->




    <!-- Carousel
    ================================================== -->
    <div id="homeCarousel" class="carousel slide carousel-home" data-ride="carousel">

          <!-- Indicators -->
         <!-- <ol class="carousel-indicators">
            <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#homeCarousel" data-slide-to="1"></li>
            <li data-target="#homeCarousel" data-slide-to="2"></li>
          </ol>-->
		  <ol class="carousel-indicators">
         <?php
		  $sliderList=$website->selectAllSliderImg();
		 
               $i=0;
                   if(count($sliderList)){
                       foreach ($sliderList as $value) {
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
                  }
    ?>
          </ol>
		  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
      <?php
               $a=0;
                 if(count($sliderList)){
                         foreach ($sliderList as $value) {
                                       if($a==0){
                ?>
				<div class="item active"><img src="assets/images/slider/<?php echo $value->slider; ?>" alt="..."></div>
				
				<?php
			
                $a++;
            }
            else
            {
               ?>
			   <div class="item"><img src="assets/images/slider/<?php echo $value->slider; ?>" alt="..."></div>
			   <?php
                $a++;
            }
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

    </div><!-- /.carousel -->

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
										 <p>VTO came into existence after like minded business men amongst us carnetogether in 2018 to facilitate and create a fOrum for all business men amongst our community.</p>
										 <p>VTO has been established with a planc strategy and to open avenues ta solve issues of Mamma Comm u nit'/</p>
									
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
                                         <p>Vokkaliga Tiade Organisation (VTOaspires to become a World Class organization of all Vokkaliga Businessmen and professiona Is by promoting each other's business every second and by adding value to every single enterprise amongst us thereby benefitting one and all.</p>
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
										 <p>VTO is set to 	ieve socio-economic empowerment, value based educationr community welfare, practice Of compassionr spread of global friend ship.</p>
										 <p>VTO invites all Vokkaligas from co-workers for its objectives.	the world aver to become a united force as contributor, collaborator and</p>
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
                                VTO would facilitate a Platform for young entrepreneurs far right business contacts and employment.
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
                                         <p>VTO would facilitate a Platform for young entrepreneurs far right business contacts and employment.</p>
										 <p>Channelize united and systematic efforts towards creating a bright future for the vouth including education sponsorship, [oans etc„</p>
										 <p>Create platform for young entrepreneurs to interact and gain knowledge from the experienced and well established busi ness leaders.</p>
										 <p>VTO would facilitate a Platform for young entrepreneurs far right business contacts and employment.</p>
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

        </div>
        
    </div> <!-- /.our-causes -->

    

    


    <div class="section-home our-sponsors animate-onscroll fadeIn">
    
        <div class="container">

            <h2 class="title-style-1">Our Sponsors <span class="title-under"></span></h2>

            <ul class="owl-carousel list-unstyled list-sponsors">

              <li> <img src="assets/images/sponsors/bus.png" alt=""></li>
              <li> <img src="assets/images/sponsors/wikimedia.png" alt=""></li>
              <li> <img src="assets/images/sponsors/one-world.png" alt=""></li>
              <li> <img src="assets/images/sponsors/wikiversity.png" alt=""></li>
              <li> <img src="assets/images/sponsors/united-nations.png" alt=""></li>

              <li> <img src="assets/images/sponsors/bus.png" alt=""></li>
              <li> <img src="assets/images/sponsors/wikimedia.png" alt=""></li>
              <li> <img src="assets/images/sponsors/one-world.png" alt=""></li>
              <li> <img src="assets/images/sponsors/wikiversity.png" alt=""></li>
              <li> <img src="assets/images/sponsors/united-nations.png" alt=""></li>

            </ul>

        </div>

    </div> <!-- /.our-sponsors -->


    


    <footer class="main-footer">

        <div class="footer-top">
            
        </div>


        <div class="footer-main">
            <div class="container">
                
                <div class="row">
                    <div class="col-md-6">

                        <div class="footer-col">

                            <h4 class="footer-title">About us <span class="title-under"></span></h4>

                            <div class="footer-content">

                                <p>
                                    <strong>Vokkaliga Trade Organisation(VTO)</strong> to become a World Class organization of all Vokkaliga Businessmen and professionals by promoting each other's business every second and by adding value to every single enterprise amongst us thereby benefitting one and all.

                                </p> 

                                <p>
                                    To Unite influential and powerful businessmen, industrialists and knowledge workers of the Vokkaliga Community across the world for Creating Value Based Education, Mutual Growth in business by mutual co-operation, avoidance of criticism, competition and opposition and also support noble causes such as Service, Knowledge, Economic Empowerment, Social Upliftment, Kannada Language, Environment and Spiritual Enlightenment amongst one and all in the Vokkaliga community

                                </p>

                            </div>
                            
                        </div>

                    </div>

                    <!-- <div class="col-md-4">

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

                    </div> -->


                    <div class="col-md-6">

                        <div class="footer-col">

                            <h4 class="footer-title">Contact us <span class="title-under"></span></h4>

                            <div class="footer-content">

                                <div class="footer-form">
                                    
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

                    </div>
                    <div class="clearfix"></div>



                </div>
                
                
            </div>

            
        </div>

        <div class="footer-bottom">

            <div class="container text-right">
                Vokkaligara Trade Organisation @ copyrights 2022 - by <a href="http://fernhilltechnologies.com/" target="_blank">Fernhill Technologies</a>
            </div>
        </div>
        
    </footer> <!-- main-footer -->




    <!-- Donate Modal -->
    <div class="modal fade" id="donateModal" tabindex="-1" role="dialog" aria-labelledby="donateModalLabel" aria-hidden="true">

      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="donateModalLabel">DONATE NOW</h4>
          </div>
          <div class="modal-body">

                <form class="form-donation">

                        <h3 class="title-style-1 text-center">Thank you for your donation <span class="title-under"></span>  </h3>

                        <div class="row">

                            <div class="form-group col-md-12 ">
                                <input type="text" class="form-control" id="amount" placeholder="AMOUNT(€)">
                            </div>

                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="firstName" placeholder="First name*">
                            </div>

                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="lastName" placeholder="Last name*">
                            </div>
                        </div>


                        <div class="row">

                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="email" placeholder="Email*">
                            </div>

                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="phone" placeholder="Phone">
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="address" placeholder="Address">
                            </div>

                        </div>


                        <div class="row">

                            <div class="form-group col-md-12">
                                <textarea cols="30" rows="4" class="form-control" name="note" placeholder="Additional note"></textarea>
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary pull-right" name="donateNow" >DONATE NOW</button>
                            </div>

                        </div>



                       
                    
                </form>
            
          </div>
        </div>
      </div>

    </div> <!-- /.modal -->





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
