<?php
$id=$_GET['id'];

include 'db_connect.php';

?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Gallery | Charity / Non-profit responsive Bootstrap HTML5 template</title>
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
		
        <link rel="stylesheet" href="assets/css/viewbox.css">
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

                    <li><a href="index.php">HOME</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                    <li class="has-child"><a href="events.php">EVENTS</a>

                      <ul class="submenu">
                        <li class="submenu-item"><a href="#">Event 1 </a></li>
                        <li class="submenu-item"><a href="#">Event 2 </a></li>
                        <li class="submenu-item"><a href="#">Event 3 </a></li>
                        <li class="submenu-item"><a href="#">Event 4 </a></li>
                      </ul>

                    </li>
                    <li><a class="is-active" href="gallery.php">GALLERY</a></li>
                    <li><a href="members.php">MEMBERS</a></li>
                    <li><a href="contact.php">CONTACT US</a></li>

                  </ul>

                </div> <!-- /#navbar -->

              </div> <!-- /.container -->
              
            </div> <!-- /.navbar-main -->


        </nav> 

    </header> <!-- /. main-header -->


	<div class=" text-center">
  <?php
// SQL query to select data from database
$sql = "SELECT * FROM album_list WHERE id = $id";
$result = $mysqli->query($sql);
?>
        
			<?php
			$album=$result->fetch_assoc();
                
			?>	
		<div class="container zoomIn animated">
			
			<h1 class="page-title"><?php echo $album['title']; ?><span class="title-under"></span></h1>
			
		</div>

	</div>

	<div class="section-home our-causes">

        <div class="container">
		
		<div class="row">
                
                <div class="col-md-2 col-sm-3">

                      <a href="gallery.php" class="btn btn-primary"> Back </a>
                        

                    </div> <!-- /.cause -->
					
     
        </div>
			<br>	
				

             <div class="row">	
                <div class="col-md-3 col-sm-6">

                    <div class="cause">

             <?php
               // SQL query to select data from database
               $sql1 = "SELECT * FROM gallery WHERE album_id = $id LIMIT 1";
               $result1 = $mysqli->query($sql1);
             ?>
                 <?php
			             $image=$result1->fetch_assoc();
                      
			      ?>
                        <img src="assets/images/gallery/album_<?php echo $image['album_id']; ?>/<?php echo $image['image']; ?>" alt="" class="cause-img" >
               			
						
                        <!-- <div class="progress cause-progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                            400$ / 700$
                          </div>
                        </div> -->

                        
						
                        </div>

                        

                    </div> <!-- /.cause -->
					<div class="col-md-3 col-sm-6">
					
					     <h4 class="cause-title"><a href="#"><?php echo $album['title']; ?></a></h4>
                        
                                <p class=""><?php echo $album['description']; ?></p>
                        
					
					
					 </div>
                    </div>

            <!-- <h2 class="title-style-1">About Us<span class="title-under"></span></h2> -->
		
			  <?php
               // SQL query to select data from database
               $sql2 = "SELECT * FROM gallery WHERE album_id = $id";
               $result2 = $mysqli->query($sql2);
             ?>
			 <div class="row">
                 <?php
			             while($image=$result2->fetch_assoc()){                      
			      ?>
                <div class="col-md-2 col-sm-3">

                    <div class="cause">
                          <a href="assets/images/gallery/album_<?php echo $image['album_id']; ?>/<?php echo $image['image']; ?>" class="image-link">
								   <img src="assets/images/gallery/album_<?php echo $image['album_id']; ?>/<?php echo $image['image']; ?>" alt="" class="cause-img" >
                          </a>
           
                       
               			 
                    </div>

                        

                    </div> <!-- /.cause -->
                 <?php
              
                   }
    
              ?>   
                </div>

        </div>
        
    </div> <!-- /.our-causes -->


	</div> <!-- /.main-container  -->


</footer> <!-- main-footer -->





       
        
        <!-- jQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/jquery-1.11.1.min.js"><\/script>')</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="assets/js/jquery.viewbox.min.js"></script>

		<script>
	$('.image-link').viewbox({
		setTitle: true,
		margin: 20,
		resizeDuration: 300,
		openDuration: 200,
		closeDuration: 200,
		closeButton: true,
		navButtons: true,
		closeOnSideClick: true,
		nextOnContentClick: true
	});

		
        </script>
		
        <!-- Bootsrap javascript file -->
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- PrettyPhoto javascript file -->
        <script src="assets/js/jquery.prettyPhoto.js"></script>

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
