<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Madhunivas</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/contact.css" rel="stylesheet">
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
       <li> <a class="dropdown" href="saleA.php" target="_blank">Dashboard</a></li>   
       <li> <a class="dropdown" href="logout.php">Log Out</a></li>
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
				<a class="navbar-brand" href="index.html"><img src="img/logo.png" alt="logo"/><span>Madhunivas</span> </a>
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
				  <li><a class="m_tag" href="about.php">About Us</a></li>
				<li><a class="m_tag active_tab" href="contact.php">Contact</a></li>
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
	 <h2 class="mgt">CONTACT US</h2>
	 <h5><a href="#">Home</a>  /  Contact Us</h5>
	</div>
   </div>
   <div class="contact_1 clearfix">
    <div class="col-sm-12">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114964.53925916665!2d-80.29949920266738!3d25.782390733064336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b0a20ec8c111%3A0xff96f271ddad4f65!2sMiami%2C+FL%2C+USA!5e0!3m2!1sen!2sin!4v1530774403788" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen=""></iframe>
	</div>
   </div>
   <div class="contact_1 clearfix">
	 <div class="col-sm-12 space_all">
	  <div class="col-sm-8">
	   <div class="contact_1il clearfix">
	     <h4 class="mgt">CONTACT US</h4>
		 <input class="form-control" placeholder="First Name" type="text">
		 <input class="form-control" placeholder="Last Name" type="text">
		 <input class="form-control" placeholder="Email" type="text">
		 <textarea  placeholder="Message" class="form-control form_1"></textarea>
		 <h5><a class="button" href="#">Submit</a></h5>
	   </div>
	  </div>
	  <div class="col-sm-4">
	   <div class="contact_1ir clearfix">
	    <h4 class="head_1 mgt">CONTACT DETAILS</h4><br><br>
		<p class="col">Please find below contact details and contact us today!</p><br>
		<h5 class="col"><i class="fa fa-map-marker"></i>Mangalore</h5>
		<h5 class="col"><i class="fa fa-phone"></i> +91 1234567890</h5>
		<h5 class="col"><i class="fa fa-envelope"></i>madhunivas@gmail.com</h5>
		<h5 class="col"><i class="fa fa-clock-o"></i> 9:00 a.m - 7:00 p.m</h5>
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
	  <p class="col_3">© 2021 madhunivas. All Rights Reserved | Design by <a class="col" href="http://fernhilltechnologies.com/">FERNHILL TECHNOLOGIES</a></p>
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
