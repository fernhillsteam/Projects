<?php
include_once "connect.php";

$query = "select * from register limit 1";
$result = mysqli_query($con, $query);

if(!$result){
	echo "Error Found!!!";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Madhunivas</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
	<script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <style>
  .dropdown-menu a:hover {
	  background:orange;
	  }
  </style>
 
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
<!--	<div class="dropdown">
  <a onclick="myFunction()" class="dropbtn">Dropdown</a>
  <div id="myDropdown" class="dropdown-content">
    <a href="#home">Home</a>
    <a href="#about">About</a>
    <a href="#contact">Contact</a>
  </div>
</div>-->
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
				<li><a class="m_tag active_tab" href="index.php">Home</a></li>
				<li class="dropdown">
					  <a class="m_tag" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Property<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="listing.php">Buy Property</a></li>
						<li><a href="l-rent.php">Rent Property</a></li>
						<!-- <li><a class="border_none" href="detail.html">Property Detail</a></li> -->
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
				<li><a class="m_tag" href="contact.php">Contact</a></li>
			</ul>
		    	<ul class="nav navbar-nav navbar-right nav_2">

				  <!-- <li><a class="m_tag button mgt" href="submit.html">Submit Property</a></li> -->
				  
	 <!-- <select class="form-control" name="property" style="color: #e87703;">
		<option value="">Buy/Sell/Rent</option>
		<option value="for-sale"><a href="demo.html">Buy</a></option>
		<option value="for-rent">Sell</option>
		<option value="sold">Rent</option>
    </select> -->
				</ul>
			
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->
	</nav>
	
	</section>
	
<section id="center" class="center_home clearfix">
<div class="center_main clearfix">
 <div class="w3-content w3-section clearfix">
  <img class="mySlides w3-animate-top" src="img/1.png" alt="abc" style="width: 100%; display: none;">
  <img class="mySlides w3-animate-bottom" src="img/2.png" alt="abc" style="width: 100%; display: block;">
  <img class="mySlides w3-animate-top" src="img/3.png" alt="abc" style="width: 100%; display: none;">
</div>
 <div class="center_main_1 clearfix">
  <div class="col-sm-8"></div>
  <div class="col-sm-4">
   <div class="center_main_1r clearfix">
     <h5 class="mgt col">Property Status</h5>
	 <select class="form-control" name="property">
		<option value="">Any Status</option>
		<option value="for-sale">For Sale</option>
		<option value="for-rent">For Rent</option>
		<option value="sold">Sold</option>
    </select>
	<h5 class="col">Property Type</h5>
	<select class="form-control" name="property">
		<option value="">Any Type</option>
		<option value="family-house">Family House</option>
		<option value="apartment">Apartment</option>
		<option value="condo">Condo</option>
    </select>
	<h5 class="col">Location</h5>
	<select class="form-control" name="Location">
		<option value="">Any Location</option>
		<option value="family-house">Mysore</option>
		<option value="apartment">Banglore</option>
		<option value="condo">Manglore</option>
		<option value="condo">Udupi</option>
		
   </select>
   <h5 class="col">Price</h5>
	<select class="form-control" name="Price">
		<option value="">&#8377;54,000 - &#8377;130,000</option>
		<option value="family-house">&#8377;44,000 - &#8377;140,000</option>
		<option value="apartment">&#8377;74,000 - &#8377;150,000</option>
		<option value="condo">&#8377;84,000 - &#8377;160,000</option>
		<option value="condo">&#8377;94,000 - &#8377;170,000</option>
		<option value="condo">&#8377;44,000 - &#8377;120,000</option>
   </select>
   <div class="center_main_1ri clearfix">
    <div class="col-sm-6 space_left">
	 <h5 class="col">Bedrooms</h5>
	 <select class="form-control" name="beds" id="beds">
		<option value="">Any</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
     </select>
	</div>
	<div class="col-sm-6 space_right">
	 <h5 class="col">Bathrooms</h5>
	 <select class="form-control" name="beds" id="beds">
		<option value="">Any</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
     </select>
	</div>
   </div>
   <div class="center_main_1ri clearfix">
    <div class="col-sm-6 space_left">
	 <h5 class="col">Area (Min)</h5>
	 <div class="input-group number-spinner">
				<span class="input-group-btn">
					<button class="btn btn-default" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></button>
				</span>
				<input type="text" class="form-control mgt text-center" value="1">
				<span class="input-group-btn">
					<button class="btn btn-default" data-dir="up"><span class="glyphicon glyphicon-plus"></span></button>
				</span>
	</div>
	</div>
	<div class="col-sm-6 space_right">
	 <h5 class="col">Area (Max)</h5>
	 <div class="input-group number-spinner">
				<span class="input-group-btn">
					<button class="btn btn-default" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></button>
				</span>
				<input type="text" class="form-control mgt text-center" value="1">
				<span class="input-group-btn">
					<button class="btn btn-default" data-dir="up"><span class="glyphicon glyphicon-plus"></span></button>
				</span>
	</div>
	</div>
   </div>
   <h5 class="text-center"><a class="button_1 block" href="#">SEARCH PROPERTY</a></h5>
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
	   <h4 class="mgt">Our <br><span class="col_1">Offering</span></h4>
	</div>
   </div>
    <div class="serv_home_1 clearfix">
    <div class="col-sm-4">
	   <div class="serv_home_1i clearfix">
	    <div class="serv_home_1i1 clearfix">
		 <h4 class="mgt col">Invest</h4>
		 <p class="col">Best investment  you can make is an investment in your happiness , the more you explore the more you learn & the more you learn, more you'll earn.</p>
		 <!-- <h5><a class="col" href="#">Read More <i class="fa fa-long-arrow-right"></i></a></h5> -->
		</div>
		<div class="serv_home_1i2 clearfix">
		 <span><i class="fa fa-home"></i></span>
		</div>
	   </div>
	</div>
	<div class="col-sm-4">
	   <div class="serv_home_1i clearfix">
	    <div class="serv_home_1i1 clearfix">
		 <h4 class="mgt col">Enjoy</h4>
		 <p class="col">When you invest you'll earn and when you'll earn you will definately enjoy.<br><br>
		 <br></p>
		 <!-- <h5><a class="col" href="#">Read More <i class="fa fa-long-arrow-right"></i></a></h5> -->
		</div>
		<div class="serv_home_1i2 clearfix">
		 <span><i class="fa fa-building-o"></i></span>
		</div>
	   </div>
	</div>
	<div class="col-sm-4">
	   <div class="serv_home_1i clearfix">
	    <div class="serv_home_1i1 clearfix">
		 <h4 class="mgt col">Earn</h4>
		 <p class="col">Learn not only you earn money but also how to save it.
         <br><br><br>

		 </p>
		 <!-- <h5><a class="col" href="#">Read More <i class="fa fa-long-arrow-right"></i></a></h5> -->
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





<!-- <section id="serv_home">
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
</section> -->

<section id="feature_o">
 <div class="container">
  <div class="row">
   <div class="feature_1 clearfix">
    <div class="col-sm-12">
	   <h4 class="mgt">FEATURED <br><span class="col_1">PROPERTIES</span></h4>
	</div>
   </div>
   <div class="feature_2 clearfix">
    <!-- <div class="col-sm-4">
    	<?php
	  	while($property_result = mysqli_fetch_assoc($result)){
			$id = $property_result['id'];
			$name = $property_result['name'];
			$location = $property_result['location'];
			$beds = $property_result['beds'];
			$bathrooms = $property_result['bathrooms'];
			$image = $property_result['image'];
			$parking = $property_result['parking'];
			$area = $property_result['area'];
			$price = $property_result['price'];
			/*$kitchen = $property_result['kitchen'];
			$utility = $property_result['utility'];*/

	  ?>
					 <div class="feature_2im clearfix">

					   	    <div class="feature_2im1 clearfix">
					     <a href="#"><img src="<?php echo $image;?>" class="iw" alt="abc" width="360" height="280"></a>
					    </div>
							<div class="feature_2im2 clearfix">
							 <h6 class="mgt"><a class="bg_1" href="#">Featured</a></h6>
							 <h6 class="pull-right mgt"><a class="bg_2" href="#">For Rent</a></h6>
							</div>
							<div class="feature_2im4 clearfix">
							 <div class="col-sm-6 space_left">
							   <h6><a class="bg_3" href="#">Family Home</a></h6>
							 </div>
							 <div class="col-sm-6 feature_2im4r space_right">
							   <ul class="mgt">
								<li><a href="#"><i class="fa fa-link"></i></a></li>
								<li><a href="#"><i class="fa fa-video-camera"></i></a></li>
								<li><a href="#"><i class="fa fa-photo"></i></a></li>
							   </ul>
							 </div>
							</div>
					 </div>

					 <div class="feature_2m_last clearfix">
					  <h4 class="mgt bold"><a href="#"><?php echo $name;?></a></h4>
					  <p><i class="fa fa-map-marker"></i><?php echo $location;?></p><br>
					  <h6><i class="fa fa-hotel col_1"></i><?php echo $beds;?>Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i><?php echo $bathrooms;?> Bathrooms</span></h6>
					  <h6><i class="fa fa-object-group col_1"></i> <?php echo $area;?>sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i><?php echo $parking;?> Garages</span></h6><br>
					  <h5 class="bold"><a href="#">&#8377; <?php echo $price;?> <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
					  <div class="feature_2m_last_i clearfix">
					    <h6><a href="#"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
					  </div>

					 </div>
            
					</div>
           <?php } ?> -->

  <div class="col-sm-4">
					 <div class="feature_2im clearfix">
					   	    <div class="feature_2im1 clearfix">
					     <a href="#"><img src="img/5.png" class="iw" alt="abc"></a>
					    </div>
							<div class="feature_2im2 clearfix">
							 <h6 class="mgt"><a class="bg_1" href="#">Featured</a></h6>
							 <h6 class="pull-right mgt"><a class="bg_4" href="#">For Sale</a></h6>
							</div>
							<div class="feature_2im4 clearfix">
							 <div class="col-sm-6 space_left">
							   <h6><a class="bg_3" href="#">Family Home</a></h6>
							 </div>
							 <div class="col-sm-6 feature_2im4r space_right">
							   <ul class="mgt">
								<li><a href="#"><i class="fa fa-link"></i></a></li>
								<li><a href="#"><i class="fa fa-video-camera"></i></a></li>
								<li><a href="#"><i class="fa fa-photo"></i></a></li>
							   </ul>
							 </div>
							</div>
					 </div>
					 <div class="feature_2m_last clearfix">
					  <h4 class="mgt bold"><a href="#">Residential Land for sale at Kunnathunad, Ernakulam</a></h4>
					  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
					  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
					  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
					  <h5 class="bold"><a href="#">&#8377; 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
					  <div class="feature_2m_last_i clearfix">
					    <h6><a href="#"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
					  </div>
					 </div>
					</div> 

	<div class="col-sm-4">
					 <div class="feature_2im clearfix">
					   	    <div class="feature_2im1 clearfix">
					     <a href="#"><img src="img/5.png" class="iw" alt="abc"></a>
					    </div>
							<div class="feature_2im2 clearfix">
							 <h6 class="mgt"><a class="bg_1" href="#">Featured</a></h6>
							 <h6 class="pull-right mgt"><a class="bg_4" href="#">For Sale</a></h6>
							</div>
							<div class="feature_2im4 clearfix">
							 <div class="col-sm-6 space_left">
							   <h6><a class="bg_3" href="#">Family Home</a></h6>
							 </div>
							 <div class="col-sm-6 feature_2im4r space_right">
							   <ul class="mgt">
								<li><a href="#"><i class="fa fa-link"></i></a></li>
								<li><a href="#"><i class="fa fa-video-camera"></i></a></li>
								<li><a href="#"><i class="fa fa-photo"></i></a></li>
							   </ul>
							 </div>
							</div>
					 </div>
					 <div class="feature_2m_last clearfix">
					  <h4 class="mgt bold"><a href="#">home2</a></h4>
					  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
					  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
					  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
					  <h5 class="bold"><a href="#">&#8377; 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
					  <div class="feature_2m_last_i clearfix">
					    <h6><a href="#"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
					  </div>
					 </div>
					</div>

	<div class="col-sm-4">
					 <div class="feature_2im clearfix">
					   	    <div class="feature_2im1 clearfix">
					     <a href="#"><img src="img/6.png" class="iw" alt="abc"></a>
					    </div>
							<div class="feature_2im2 clearfix">
							 <h6 class="mgt"><a class="bg_1" href="#">Featured</a></h6>
							 <h6 class="pull-right mgt"><a class="bg_2" href="#">For Rent</a></h6>
							</div>
							<div class="feature_2im4 clearfix">
							 <div class="col-sm-6 space_left">
							   <h6><a class="bg_3" href="#">Family Home</a></h6>
							 </div>
							 <div class="col-sm-6 feature_2im4r space_right">
							   <ul class="mgt">
								<li><a href="#"><i class="fa fa-link"></i></a></li>
								<li><a href="#"><i class="fa fa-video-camera"></i></a></li>
								<li><a href="#"><i class="fa fa-photo"></i></a></li>
							   </ul>
							 </div>
							</div>
					 </div>
					 <div class="feature_2m_last clearfix">
					  <h4 class="mgt bold"><a href="#">home3</a></h4>
					  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
					  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
					  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
					  <h5 class="bold"><a href="#">&#8377; 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
					  <div class="feature_2m_last_i clearfix">
					    <h6><a href="#"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
					  </div>
					 </div>
					</div>

   </div>

   <div class="feature_2 clearfix">
    <div class="col-sm-4">
					 <div class="feature_2im clearfix">
					   	    <div class="feature_2im1 clearfix">
					     <a href="#"><img src="img/7.png" class="iw" alt="abc"></a>
					    </div>
							<div class="feature_2im2 clearfix">
							 <h6 class="mgt"><a class="bg_1" href="#">Featured</a></h6>
							 <h6 class="pull-right mgt"><a class="bg_2" href="#">For Rent</a></h6>
							</div>
							<div class="feature_2im4 clearfix">
							 <div class="col-sm-6 space_left">
							   <h6><a class="bg_3" href="#">Family Home</a></h6>
							 </div>
							 <div class="col-sm-6 feature_2im4r space_right">
							   <ul class="mgt">
								<li><a href="#"><i class="fa fa-link"></i></a></li>
								<li><a href="#"><i class="fa fa-video-camera"></i></a></li>
								<li><a href="#"><i class="fa fa-photo"></i></a></li>
							   </ul>
							 </div>
							</div>
					 </div>
					 <div class="feature_2m_last clearfix">
					  <h4 class="mgt bold"><a href="#">home4</a></h4>
					  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
					  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
					  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
					  <h5 class="bold"><a href="#">&#8377; 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
					  <div class="feature_2m_last_i clearfix">
					    <h6><a href="#"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
					  </div>
					 </div>
					</div>

	<div class="col-sm-4">
					 <div class="feature_2im clearfix">
					   	    <div class="feature_2im1 clearfix">
					     <a href="#"><img src="img/8.png" class="iw" alt="abc"></a>
					    </div>
							<div class="feature_2im2 clearfix">
							 <h6 class="mgt"><a class="bg_1" href="#">Featured</a></h6>
							 <h6 class="pull-right mgt"><a class="bg_4" href="#">For Sale</a></h6>
							</div>
							<div class="feature_2im4 clearfix">
							 <div class="col-sm-6 space_left">
							   <h6><a class="bg_3" href="#">Family Home</a></h6>
							 </div>
							 <div class="col-sm-6 feature_2im4r space_right">
							   <ul class="mgt">
								<li><a href="#"><i class="fa fa-link"></i></a></li>
								<li><a href="#"><i class="fa fa-video-camera"></i></a></li>
								<li><a href="#"><i class="fa fa-photo"></i></a></li>
							   </ul>
							 </div>
							</div>
					 </div>
					 <div class="feature_2m_last clearfix">
					  <h4 class="mgt bold"><a href="#">home5</a></h4>
					  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
					  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
					  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
					  <h5 class="bold"><a href="#">&#8377; 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
					  <div class="feature_2m_last_i clearfix">
					    <h6><a href="#"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
					  </div>
					 </div>
					</div>

	<div class="col-sm-4">
					 <div class="feature_2im clearfix">
					   	    <div class="feature_2im1 clearfix">
					     <a href="#"><img src="img/9.png" class="iw" alt="abc"></a>
					    </div>
							<div class="feature_2im2 clearfix">
							 <h6 class="mgt"><a class="bg_1" href="#">Featured</a></h6>
							 <h6 class="pull-right mgt"><a class="bg_2" href="#">For Rent</a></h6>
							</div>
							<div class="feature_2im4 clearfix">
							 <div class="col-sm-6 space_left">
							   <h6><a class="bg_3" href="#">Family Home</a></h6>
							 </div>
							 <div class="col-sm-6 feature_2im4r space_right">
							   <ul class="mgt">
								<li><a href="#"><i class="fa fa-link"></i></a></li>
								<li><a href="#"><i class="fa fa-video-camera"></i></a></li>
								<li><a href="#"><i class="fa fa-photo"></i></a></li>
							   </ul>
							 </div>
							</div>
					 </div>
					 <div class="feature_2m_last clearfix">
					  <h4 class="mgt bold"><a href="#">home6</a></h4>
					  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
					  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
					  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
					  <h5 class="bold"><a href="#">&#8377; 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
					  <div class="feature_2m_last_i clearfix">
					    <h6><a href="#"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
					  </div>
					 </div>
					</div>

   </div>
   <div class="feature_o_last clearfix">
    <div class="col-sm-12">
	 <h5 class="text-center mgt"><a class="button mgt" href="listing.php">View All <i class="fa fa-long-arrow-right"></i></a></h5>
	</div>
   </div>
  </div>

 </div>
</section>

<section id="popular">
 <div class="container">
  <div class="row">
   <div class="feature_1 clearfix">
    <div class="col-sm-12">
	   <h4 class="mgt">MOST POPULAR <br><span class="col_1">PLACES</span></h4>
	</div>
   </div>
   <div class="popular_1 clearfix">
    <div class="col-sm-4">
	 <div class="popular_1i clearfix">
	  <div class="popular_1i1 clearfix">
	   <a href="#"><img src="img/11.png" class="iw" alt="abc"></a>
	  </div>
	  <div class="popular_1i2 text-center clearfix">
	   <h4 class="mgt"><a  class="col" href="#">Udupi</a></h4>
	   <h5><a class="col" href="#">213 Properties</a></h5>
	  </div>
	 </div>
	</div>
	<div class="col-sm-8">
	 <div class="popular_1i clearfix">
	  <div class="popular_1i1 clearfix">
	   <a href="#"><img src="img/12.png" class="iw" alt="abc"></a>
	  </div>
	  <div class="popular_1i2 text-center clearfix">
	   <h4 class="mgt"><a  class="col" href="#">Mysore</a></h4>
	   <h5><a class="col" href="#">283 Properties</a></h5>
	  </div>
	 </div>
	</div>
   </div>
   <div class="popular_1 clearfix">
	<div class="col-sm-8">
	 <div class="popular_1i clearfix">
	  <div class="popular_1i1 clearfix">
	   <a href="#"><img src="img/13.png" class="iw" alt="abc"></a>
	  </div>
	  <div class="popular_1i2 text-center clearfix">
	   <h4 class="mgt"><a  class="col" href="#">Mangalore</a></h4>
	   <h5><a class="col" href="#">435 Properties</a></h5>
	  </div>
	 </div>
	</div>
	<div class="col-sm-4">
	 <div class="popular_1i clearfix">
	  <div class="popular_1i1 clearfix">
	   <a href="#"><img src="img/14.png" class="iw" alt="abc"></a>
	  </div>
	  <div class="popular_1i2 text-center clearfix">
	   <h4 class="mgt"><a  class="col" href="#">Chamarajanagar</a></h4>
	   <h5><a class="col" href="#">343 Properties</a></h5>
	  </div>
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
				  <p>Real estate agents guide clients through the buying and selling of properties. As a seller, they help clients place their home on the market and provide consultation on how to best prepare the home for a successful and fast sale.</p>
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
				  <p>Real estate agents guide clients through the buying and selling of properties. As a seller, they help clients place their home on the market and provide consultation on how to best prepare the home for a successful and fast sale.</p>
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
				  <p>Real estate agents guide clients through the buying and selling of properties. As a seller, they help clients place their home on the market and provide consultation on how to best prepare the home for a successful and fast sale.</p>
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
				  <p>Real estate agents guide clients through the buying and selling of properties. As a seller, they help clients place their home on the market and provide consultation on how to best prepare the home for a successful and fast sale.</p>
				  <h5><a class="button" href="#">View Profile</a></h5>
			  </div>
            </div>
	  </div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="news_h">
 <div class="container">
  <div class="row">
   <div class="feature_1 clearfix">
    <div class="col-sm-12">
	   <h4 class="mgt">LATEST <br><span class="col_1">NEWS</span></h4>
	</div>
   </div>
   <div class="news_h_1 clearfix">
    <div class="col-sm-6">
     <div class="news_h_1i clearfix">
	   <div class="col-sm-5 space_all">
	    <div class="news_h_1ir clearfix">
		 <a href="#"><img src="img/19.jpg" class="iw" alt="abc"></a>
		</div>
	   </div>
	   <div class="col-sm-7 space_all">
	    <div class="news_h_1il clearfix">
		 <h4 class="mgt"><a href="#">The Real Estate News</a></h4>
		 <h6>Jan 21, 2020  /  By Admin</h6>
		 <p>Realty developers likely to post record bookings in October-December</p>
		 <div class="news_h_1ili clearfix">
		  <div class="col-sm-4 space_all">
		   <h5><a class="col_1 bold" href="#">Read more...</a></h5>
		  </div>
		  <div class="col-sm-8 space_right">
		   <ul>
		    <li><i class="fa fa-heart col_1"></i> 336</li>
			<li><i class="fa fa-comment col_1"></i> 39</li>
			<li><i class="fa fa-share-alt col_1"></i> 142</li>
		   </ul>
		  </div>
		 </div>
		</div>
	   </div>
	 </div>
	</div>
	<div class="col-sm-6">
     <div class="news_h_1i clearfix">
	   <div class="col-sm-5 space_all">
	    <div class="news_h_1ir clearfix">
		 <a href="#"><img src="img/20.jpg" class="iw" alt="abc"></a>
		</div>
	   </div>
	   <div class="col-sm-7 space_all">
	    <div class="news_h_1il clearfix">
		 <h4 class="mgt"><a href="#">The Real Estate News</a></h4>
		 <h6>Jan 21, 2020  /  By Admin</h6>
		 <p>Realty developers likely to post record bookings in October-December</p>
		 <div class="news_h_1ili clearfix">
		  <div class="col-sm-4 space_all">
		   <h5><a class="col_1 bold" href="#">Read more...</a></h5>
		  </div>
		  <div class="col-sm-8 space_right">
		   <ul>
		    <li><i class="fa fa-heart col_1"></i> 336</li>
			<li><i class="fa fa-comment col_1"></i> 39</li>
			<li><i class="fa fa-share-alt col_1"></i> 142</li>
		   </ul>
		  </div>
		 </div>
		</div>
	   </div>
	 </div>
	</div>
   </div>
   <div class="news_h_1 clearfix">
    <div class="col-sm-6">
     <div class="news_h_1i clearfix">
	   <div class="col-sm-5 space_all">
	    <div class="news_h_1ir clearfix">
		 <a href="#"><img src="img/21.jpg" class="iw" alt="abc"></a>
		</div>
	   </div>
	   <div class="col-sm-7 space_all">
	    <div class="news_h_1il clearfix">
		 <h4 class="mgt"><a href="#">The Real Estate News</a></h4>
		 <h6>Jan 21, 2020  /  By Admin</h6>
		 <p>Realty developers likely to post record bookings in October-December</p>
		 <div class="news_h_1ili clearfix">
		  <div class="col-sm-4 space_all">
		   <h5><a class="col_1 bold" href="#">Read more...</a></h5>
		  </div>
		  <div class="col-sm-8 space_right">
		   <ul>
		    <li><i class="fa fa-heart col_1"></i> 336</li>
			<li><i class="fa fa-comment col_1"></i> 39</li>
			<li><i class="fa fa-share-alt col_1"></i> 142</li>
		   </ul>
		  </div>
		 </div>
		</div>
	   </div>
	 </div>
	</div>
	<div class="col-sm-6">
     <div class="news_h_1i clearfix">
	   <div class="col-sm-5 space_all">
	    <div class="news_h_1ir clearfix">
		 <a href="#"><img src="img/22.jpg" class="iw" alt="abc"></a>
		</div>
	   </div>
	   <div class="col-sm-7 space_all">
	    <div class="news_h_1il clearfix">
		 <h4 class="mgt"><a href="#">The Real Estate News</a></h4>
		 <h6>Jan 21, 2020  /  By Admin</h6>
		 <p>Realty developers likely to post record bookings in October-December</p>
		 <div class="news_h_1ili clearfix">
		  <div class="col-sm-4 space_all">
		   <h5><a class="col_1 bold" href="#">Read more...</a></h5>
		  </div>
		  <div class="col-sm-8 space_right">
		   <ul>
		    <li><i class="fa fa-heart col_1"></i> 336</li>
			<li><i class="fa fa-comment col_1"></i> 39</li>
			<li><i class="fa fa-share-alt col_1"></i> 142</li>
		   </ul>
		  </div>
		 </div>
		</div>
	   </div>
	 </div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="user">
 <div class="container">
  <div class="row">
   <div class="feature_1 clearfix">
    <div class="col-sm-12">
	   <h4 class="mgt">HAPPY <br><span class="col_1">CUSTOMERS</span></h4>
	</div>
   </div>
   <div class="user_1 clearfix">
     <div id="Carousel" class="carousel slide">
                 
                <ol class="carousel-indicators">
                    <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#Carousel" data-slide-to="1" class=""></li>
                    <li data-target="#Carousel" data-slide-to="2" class=""></li>
                </ol>
                 
                <!-- Carousel items -->
                <div class="carousel-inner">
                    
                <div class="item active">
                	<div class="row">
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/27.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>John</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/28.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>Tom</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-half-o"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/29.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>Shaam</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	</div><!--.row-->
                </div><!--.item-->
                 
                <div class="item">
                	<div class="row">
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/30.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>Kumar</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/31.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>Alex</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-half-o"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/32.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>Chandan</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	</div><!--.row-->
                </div><!--.item-->
                 
                <div class="item">
                	<div class="row">
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/33.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>Luis</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/34.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>Lacinia</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	  <div class="col-sm-4">
					   <div class="testimonial_hm text-center clearfix">
					      <img src="img/35.jpg" alt="abc" class="img-circle mgt">
					      <p>A customer review is a review of a product or service made by a customer who has purchased and used, or had experience with, the product or service.</p>
                           <hr>
					       <h4>Nunc</h4>
						   <span class="span_1">
						    <i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-half-o"></i>
						   </span>
					       <h5>Student</h5>
					   </div>
                      </div>
                	</div><!--.row-->
                </div><!--.item-->
                 
                </div><!--.carousel-inner-->
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
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 2500);    
}
</script>

<script type="text/javascript">
	$(document).on('click', '.number-spinner button', function () {    
	var btn = $(this),
		oldValue = btn.closest('.number-spinner').find('input').val().trim(),
		newVal = 0;
	
	if (btn.attr('data-dir') == 'up') {
		newVal = parseInt(oldValue) + 1;
	} else {
		if (oldValue > 1) {
			newVal = parseInt(oldValue) - 1;
		} else {
			newVal = 1;
		}
	}
	btn.closest('.number-spinner').find('input').val(newVal);
});
	</script>
	
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
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

</body>
 
</html>
