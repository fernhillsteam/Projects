<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Madhunivas</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/about.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
	<script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  
<body>
<section id="top">
<div class="container">
 <div class="row">
  <div class="top_1 clearfix">
   <div class="col-sm-6">
    <div class="top_1l clearfix">
	 <ul>
	  <li><i class="fa fa-phone"></i> (IND) 0123 45678</li>
	  <li><i class="fa fa-map-marker"></i>(Mysore) India</li>
	  <li><i class="fa fa-envelope-o"></i>madhunivas@gmail.com</li>
	 </ul>
	</div>
   </div>
   <div class="col-sm-6">
    <div class="top_1r pull-right clearfix">
	 <ul>
	 <?php

           session_start();
		if(isset($_SESSION["email"])){
			include "connect.php";

               $query = "select `name` from `user_login` WHERE `email`='".$_SESSION['email']."'";
               $result = mysqli_query($con, $query);
			   
			  if(mysqli_num_rows($result)>0){
			   
	  	while($row = mysqli_fetch_assoc($result)){
			$name = $row['name'];
			?>
			
			<!--<li><a class="col" href=""><i class="fa fa-user"></i><?php echo $name; ?></a></li>-->
		<li><div class="dropdown show">
  <a class="col" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fa fa-user"></i><?php echo $name; ?>
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
  <ul>
       <li> <a class="dropdown" href="sale.php" target="_blank">Dashboard</a></li>
	   
       <li> <a class="dropdown" href="logout.php">Log Out</a></li>
       <!--<li> <a class="dropdown" href="#">Another action</a></li>
       <li> <a class="dropdown" href="#">Something else here</a></li>-->
  </ul>
  </div>
</div></li>
		
				<?php
		        }
			  }else if(mysqli_num_rows($result)==0){
				  include "connect.php";

               $query = "select `name` from `admin_login` WHERE `email`='".$_SESSION['email']."'";
               $result = mysqli_query($con, $query);
			   
			  if(mysqli_num_rows($result)>0){
			   
	  	while($row = mysqli_fetch_assoc($result)){
			$name = $row['name'];
			?>
			
			<!--<li><a class="col" href=""><i class="fa fa-user"></i><?php echo $name; ?></a></li>-->
		<li><div class="dropdown show">
  <a class="col" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fa fa-user"></i><?php echo $name; ?>
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
  <ul>
       <<li><a class="dropdown" href="saleA.php" target="_blank">Dashboard</a></li>   
       <li><a class="dropdown" href="logout.php">Log Out</a></li>
      <!-- <li> <a class="dropdown" href="#">Another action</a></li>
       <li> <a class="dropdown" href="#">Something else here</a></li>-->
  </ul>
  </div>
</div></li>
		
				<?php
		        }
			  }
		}
		}else{
			
				 echo '<li><a class="col" href="login.php"><i class="fa fa-user"></i>Login/Register</a></li>';
	             
		
		}
      ?>

	  <li><a class="col" href="#"><i class="fa fa-facebook"></i></a></li>
	  <li><a class="col" href="#"><i class="fa fa-twitter"></i></a></li>
	  <li><a class="col" href="#"><i class="fa fa-linkedin"></i></a></li>
	 </ul>
	 <select class="form-control">
				 <option>English</option>
				 <!-- <option>German</option>
				 <option>France</option>
				 <option>Italy</option> -->
     </select>
	</div>
   </div>
  </div>
 </div>
</div>
</section>	

<section id="header" class="clearfix cd-secondary-nav">
	<nav class="navbar">
		<div class="container">
		    <div class="navbar-header page-scroll">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="logo"/><span>Madhunivas</span> </a>
			</div>
			<!-- Brand and toggle get grouped for better mobile display -->
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav nav_1">
				<li><a class="m_tag" href="index.php">Home</a></li>
				<li class="dropdown">
					  <a class="m_tag" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Property<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="listing.php">Buy Property</a></li>
						<li><a href="l-rent.php">Rent Property</a></li>
					  </ul>
                    </li>
				
				    <li class="dropdown">
					  <a class="m_tag" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Agent<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="agent.html">Agent</a></li>
						<li><a class="border_none" href="agent_detail.html">Agent Detail</a></li>
					  </ul>
                    </li>
					<li class="dropdown">
					  <a class="m_tag" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Agencies<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="agency.html">Agencies</a></li>
						<li><a class="border_none" href="agency_detail.html">Agencies Detail</a></li>
					  </ul>
                    </li>
				  <!-- <li class="dropdown">
					  <a class="m_tag" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Blog<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="blog.html">Blog</a></li>
						<li><a class="border_none" href="blog_detail.html">Blog Detail</a></li>
					  </ul>
                    </li> -->
				  <li><a class="m_tag active_tab" href="about.php">About Us</a></li>
				<li><a class="m_tag" href="contact.php">Contact</a></li>
			</ul>
		    	<ul class="nav navbar-nav navbar-right nav_2">
				  <!-- <li><a class="m_tag button mgt" href="submit.html">Submit Property</a></li> -->
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->
	</nav>
	
	</section>
	
<section id="center" class="center_blog clearfix">
 <div class="container">
  <div class="row">
   <div class="center_blog_1 text-center clearfix">
    <div class="col-sm-12">
	 <h2 class="mgt">ABOUT US</h2>
	 <h5><a href="#">Home</a>  /  About Us</h5>
	</div>
   </div>
   <div class="about_1 clearfix">
    <div class="col-sm-6">
     <div class="about_1l clearfix">
	  <h4 class="mgt">ABOUT <span class="col_1">FIND HOUSES</span></h4>
	  <p><b>MADHUNIVAS.COM - THE REAL ESTATE PORTAL OF MADHUNIVAS.COM , MANGALORE, BANGALORE, INDIA.</b></p>
	  <p>madhunivasrealestate.com, is mangalore First premium real estate portal since 1998. We are based at the metro city of mangalore/bangalore/udupi. We are pioneers in online real estate advertisement services catering to Malayalees all over the world.</p>


    <p>madhunivasrealestate.com is a platform for Builders, Real Estate Agents, Sellers and Landlords to collectively advertise their listings on the Internet. It also serves as a resource base and medium for prospective buyers across the globe who wish to search for land/property/housing in Kerala and avail of allied services.</p>

    
	  <h5><a class="button" href="#">READ MORE</a></h5>
	 </div>
	</div>
	<div class="col-sm-6">
     <div class="about_1r clearfix">
	  <img src="img/68.jpg" class="iw" alt="abc">
	 </div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="serv_home">
 <div class="serv_home_m clearfix">
   <div class="container">
  <div class="row">
    <div class="feature_1 clearfix">
    <div class="col-sm-12">
	   <h4 class="mgt">PROPERTY <br><span class="col_1">SERVICES</span></h4>
	</div>
   </div>
    <div class="serv_home_1 clearfix">
    <div class="col-sm-4">
	   <div class="serv_home_1i clearfix">
	    <div class="serv_home_1i1 clearfix">
		 <h4 class="mgt col">Houses</h4>
		 <p class="col">Nonec pede justo fringilla vel aliquet nec vulputate eget arcu in enim justo rhoncus ut imperdiet venenatis vitae justo.</p>
		 <h5><a class="col" href="#">Read More <i class="fa fa-long-arrow-right"></i></a></h5>
		</div>
		<div class="serv_home_1i2 clearfix">
		 <span><i class="fa fa-home"></i></span>
		</div>
	   </div>
	</div>
	<div class="col-sm-4">
	   <div class="serv_home_1i clearfix">
	    <div class="serv_home_1i1 clearfix">
		 <h4 class="mgt col">Apartments</h4>
		 <p class="col">Nonec pede justo fringilla vel aliquet nec vulputate eget arcu in enim justo rhoncus ut imperdiet venenatis vitae justo.</p>
		 <h5><a class="col" href="#">Read More <i class="fa fa-long-arrow-right"></i></a></h5>
		</div>
		<div class="serv_home_1i2 clearfix">
		 <span><i class="fa fa-building-o"></i></span>
		</div>
	   </div>
	</div>
	<div class="col-sm-4">
	   <div class="serv_home_1i clearfix">
	    <div class="serv_home_1i1 clearfix">
		 <h4 class="mgt col">Commercial</h4>
		 <p class="col">Nonec pede justo fringilla vel aliquet nec vulputate eget arcu in enim justo rhoncus ut imperdiet venenatis vitae justo.</p>
		 <h5><a class="col" href="#">Read More <i class="fa fa-long-arrow-right"></i></a></h5>
		</div>
		<div class="serv_home_1i2 clearfix">
		 <span><i class="fa fa-gear"></i></span>
		</div>
	   </div>
	</div>
   </div>
  </div>
 </div>
 </div>
</section>

<section id="about_home">
 <div class="container">
  <div class="row">
   <div class="about_home_1 clearfix">
    <div class="col-sm-3">
	  <div class="about_home_1i clearfix">
	   <span class="span_1"><i class="fa fa-home col_1"></i></span>
	   <h3 class="mgt">350 <br><span class="span_2">Sold Houses</span></h3>
	  </div>
	</div>
	<div class="col-sm-3">
	  <div class="about_home_1i clearfix">
	   <span class="span_1"><i class="fa fa-list col_1"></i></span>
	   <h3 class="mgt">450 <br><span class="span_2">Daily Listings</span></h3>
	  </div>
	</div>
	<div class="col-sm-3">
	  <div class="about_home_1i clearfix">
	   <span class="span_1"><i class="fa fa-users col_1"></i></span>
	   <h3 class="mgt">250 <br><span class="span_2">Expert Agents</span></h3>
	  </div>
	</div>
	<div class="col-sm-3">
	  <div class="about_home_1i clearfix">
	   <span class="span_1"><i class="fa fa-trophy col_1"></i></span>
	   <h3 class="mgt">150 <br><span class="span_2">Won Awards</span></h3>
	  </div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="team_h">
 <div class="container">
  <div class="row">
   <div class="feature_1 clearfix">
    <div class="col-sm-12">
	   <h4 class="mgt">MEET OUR <br><span class="col_1">AGENTS</span></h4>
	</div>
   </div>
   <div class="team_h_1 clearfix">
    <div class="col-sm-3">
	  <div class="team_h_1i clearfix">
	    <div class="profile clearfix">
              <div class="img-box">
                <img src="img/15.jpg" class="img-responsive">
                <ul class="text-center">
                  <a href="#"><li><i class="fa fa-facebook"></i></li></a>
                  <a href="#"><li><i class="fa fa-twitter"></i></li></a>
                  <a href="#"><li><i class="fa fa-linkedin"></i></li></a>
				  <a href="#"><li><i class="fa fa-instagram"></i></li></a>
                </ul>
              </div>
			  <div class="profilei text-center clearfix">
				  <h3 class="mgt">Arcu Eget</h3>
				  <h5>Real Estate Agent</h5>
				  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				  <h5><a class="button" href="#">View Profile</a></h5>
			  </div>
            </div>
	  </div>
	</div>
	<div class="col-sm-3">
	  <div class="team_h_1i clearfix">
	    <div class="profile clearfix">
              <div class="img-box">
                <img src="img/16.jpg" class="img-responsive">
                <ul class="text-center">
                  <a href="#"><li><i class="fa fa-facebook"></i></li></a>
                  <a href="#"><li><i class="fa fa-twitter"></i></li></a>
                  <a href="#"><li><i class="fa fa-linkedin"></i></li></a>
				  <a href="#"><li><i class="fa fa-instagram"></i></li></a>
                </ul>
              </div>
			  <div class="profilei text-center clearfix">
				  <h3 class="mgt">Mauris Massa</h3>
				  <h5>Real Estate Agent</h5>
				  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				  <h5><a class="button" href="#">View Profile</a></h5>
			  </div>
            </div>
	  </div>
	</div>
	<div class="col-sm-3">
	  <div class="team_h_1i clearfix">
	    <div class="profile clearfix">
              <div class="img-box">
                <img src="img/17.jpg" class="img-responsive">
                <ul class="text-center">
                  <a href="#"><li><i class="fa fa-facebook"></i></li></a>
                  <a href="#"><li><i class="fa fa-twitter"></i></li></a>
                  <a href="#"><li><i class="fa fa-linkedin"></i></li></a>
				  <a href="#"><li><i class="fa fa-instagram"></i></li></a>
                </ul>
              </div>
			  <div class="profilei text-center clearfix">
				  <h3 class="mgt">Ante Dapibus</h3>
				  <h5>Real Estate Agent</h5>
				  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				  <h5><a class="button" href="#">View Profile</a></h5>
			  </div>
            </div>
	  </div>
	</div>
	<div class="col-sm-3">
	  <div class="team_h_1i clearfix">
	    <div class="profile clearfix">
              <div class="img-box">
                <img src="img/18.jpg" class="img-responsive">
                <ul class="text-center">
                  <a href="#"><li><i class="fa fa-facebook"></i></li></a>
                  <a href="#"><li><i class="fa fa-twitter"></i></li></a>
                  <a href="#"><li><i class="fa fa-linkedin"></i></li></a>
				  <a href="#"><li><i class="fa fa-instagram"></i></li></a>
                </ul>
              </div>
			  <div class="profilei text-center clearfix">
				  <h3 class="mgt">Nec Odio</h3>
				  <h5>Real Estate Agent</h5>
				  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				  <h5><a class="button" href="#">View Profile</a></h5>
			  </div>
            </div>
	  </div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="footer">
 <div class="container">
  <div class="row">
   <div class="footer_1 clearfix">
     <div class="col-sm-3">
	  <div class="footer_1i clearfix">
	    <a class="navbar-brand" href="index.html"><img src="img/logo.png" alt="logo"/><span>Madhunivas</span> </a>
		<p class="col">madhunivasrealestate.com, is mangalore First premium real estate portal since 1998. We are based at the metro city of mangalore/bangalore/udupi. We are pioneers in online real estate advertisement services catering to Malayalees all over the world.</p>
		<h6 class="col_3"><i class="fa fa-map-marker col"></i>Mangalore</h6>
		<h6 class="col_3"><i class="fa fa-phone col"></i> +91 123 456 7890</h6>
		<h6 class="col_3"><i class="fa fa-envelope col"></i>madhunivas@gmail.com</h6>
	  </div>
	 </div>
	 <div class="col-sm-3">
	  <div class="footer_1i1 clearfix">
	    <h4 class="col">Navigation</h4>
		<h6><a class="col_3" href="#">Home One</a> <span class="pull-right"><a class="col_3" href="#">Agents Details</a></span></h6>
		<h6><a class="col_3" href="#">Properties Right</a> <span class="pull-right"><a class="col_3" href="#">About Us</a></span></h6>
		<h6><a class="col_3" href="#">Properties List</a> <span class="pull-right"><a class="col_3" href="#">Blog Default</a></span></h6>
		<h6><a class="col_3" href="#">Properties Details</a> <span class="pull-right"><a class="col_3" href="#">Blog Details</a></span></h6>
		<h6><a class="col_3" href="#">Agents Listing</a> <span class="pull-right"><a class="col_3" href="#">Contact Us</a></span></h6>
	  </div>
	 </div>
	 
	 <!-- <div class="col-sm-3">
	  <div class="footer_1i2 clearfix">
        <h4 class="col">Twitter Feeds</h4>
		<div class="footer_1i2i clearfix">
		 <div class="col-sm-1 space_all">
		  <span><i class="fa fa-twitter col"></i></span>
		 </div>
		 <div class="col-sm-11">
		  <p class="mgt col_3"><a class="col" href="#">@Prop Find</a> All Share Them With Me Baby Said Inspet.<br>
<span class="bold col_2">about 7 days ago</span></p>
		 </div>
		</div>
		<div class="footer_1i2i clearfix">
		 <div class="col-sm-1 space_all">
		  <span><i class="fa fa-twitter col"></i></span>
		 </div>
		 <div class="col-sm-11">
		  <p class="mgt col_3"><a class="col" href="#">@Prop Find</a> All Share Them With Me Baby Said Inspet.<br>
<span class="bold col_2">about 7 days ago</span></p>
		 </div>
		</div>
		<div class="footer_1i2i clearfix">
		 <div class="col-sm-1 space_all">
		  <span><i class="fa fa-twitter col"></i></span>
		 </div>
		 <div class="col-sm-11">
		  <p class="mgt col_3"><a class="col" href="#">@Prop Find</a> All Share Them With Me Baby Said Inspet.<br>
<span class="bold col_2">about 7 days ago</span></p>
		 </div>
		</div>
	  </div>
	  </div> -->

	  <div class="col-sm-3">
	  <div class="footer_1i3 clearfix">
        <h4 class="col">Newsletters</h4>
        <p class="col_3">Sign Up for Our Newsletter to get Latest Updates and Offers. Subscribe to receive news in your inbox.</p>
		<input class="form-control" placeholder="Enter Your Email" type="text">
		<h5 class="text-center"><a class="button block" href="#">SUBSCRIBE</a></h5>
	  </div>
	  </div>
	 </div>
   <div class="footer_2 clearfix">
    <div class="col-sm-8">
	 <div class="footer_2l clearfix">
	  <p class="col_3">?? 2021 madhunivas. All Rights Reserved | Design by <a class="col" href="http://fernhilltechnologies.com/">FERNHILL TECHNOLOGIES</a></p>
	 </div>
	</div>
	<div class="col-sm-4">
	 <div class="footer_2r text-right clearfix">
	   <ul class="social-network social-circle mgt">
                        <li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
	 </div>
	</div>
   </div>
   </div>
  </div>
</section>

<script>
$(document).ready(function(){

/*****Fixed Menu******/
var secondaryNav = $('.cd-secondary-nav'),
   secondaryNavTopPosition = secondaryNav.offset().top;
	$(window).on('scroll', function(){
		if($(window).scrollTop() > secondaryNavTopPosition ) {
			secondaryNav.addClass('is-fixed');	
		} else {
			secondaryNav.removeClass('is-fixed');
		}
	});	
	
});
</script>

</body>
 
</html>
