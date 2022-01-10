<?php
$id=$_GET['id'];

include 'db_connect.php';

?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>About | Charity / Non-profit responsive Bootstrap HTML5 template</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Dosis:400,700' rel='stylesheet' type='text/css'>

        <!-- Bootsrap -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- Font awesome -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

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

                    <li><a  href="index.html">HOME</a></li>
                    <li><a href="about.html">ABOUT US</a></li>
                    <li class="has-child"><a class="is-active" href="events.php">EVENTS</a>

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
						Date : <?php echo $rows['start_date'];?>
					</p>
					<p>
						Decription : <?php echo $rows['description'];?>
					</p>
                    <p>
						Fee : <?php echo $rows['efee'];?> RS
					</p>
					
					 <?php
                }
             ?>
				</div>

			</div> <!-- /.row -->

			

		</div> <!-- /.about-us -->
		


	</div>


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
    </body>
</html>
