<?php
include_once "connect.php";

$query = "select * from register";
$result = mysqli_query($db, $query);

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
	<link href="css/listing.css" rel="stylesheet">
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
	  <li><i class="fa fa-phone"></i>(IND) 0123 45678</li>
	  <li><i class="fa fa-map-marker"></i>(Mysore) India</li>
	  <li><i class="fa fa-envelope-o"></i>madhunivas@gmail.com</li>
	 </ul>
	</div>
   </div>
   <div class="col-sm-6">
    <div class="top_1r pull-right clearfix">
	 <ul>
	  <li><a class="col" href="detail.html"><i class="fa fa-user"></i> Login</a></li>
	  <li><a class="col" href="detail.html"><i class="fa fa-sign-in"></i> Register</a></li>
	  <li><a class="col" href="detail.html"><i class="fa fa-facebook"></i></a></li>
	  <li><a class="col" href="detail.html"><i class="fa fa-twitter"></i></a></li>
	  <li><a class="col" href="detail.html"><i class="fa fa-linkedin"></i></a></li>
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
				<a class="navbar-brand" href="index.html"><img src="img/logo.png" alt="logo"/><span>Madhunivas</span> </a>
			</div>
			<!-- Brand and toggle get grouped for better mobile display -->
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav nav_1">
				<li><a class="m_tag" href="index.html">Home</a></li>
				<li class="dropdown">
					  <a class="m_tag active_tab" href="detail.html" data-toggle="dropdown" role="button" aria-expanded="false">Property<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="listing.html">Property Listing</a></li>
						<!-- <li><a class="border_none" href="detail.html">Property Detail</a></li> -->
					  </ul>
                    </li>
				
				    <li class="dropdown">
					  <a class="m_tag" href="detail.html" data-toggle="dropdown" role="button" aria-expanded="false">Agent<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="agent.html">Agent</a></li>
						<li><a class="border_none" href="agent_detail.html">Agent Detail</a></li>
					  </ul>
                    </li>
					<li class="dropdown">
					  <a class="m_tag" href="detail.html" data-toggle="dropdown" role="button" aria-expanded="false">Agencies<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="agency.html">Agencies</a></li>
						<li><a class="border_none" href="agency_detail.html">Agencies Detail</a></li>
					  </ul>
                    </li>
				  <!-- <li class="dropdown">
					  <a class="m_tag" href="detail.html" data-toggle="dropdown" role="button" aria-expanded="false">Blog<span class="caret"></span></a>
					  <ul class="dropdown-menu drop_3" role="menu">
						<li><a href="blog.html">Blog</a></li>
						<li><a class="border_none" href="blog_detail.html">Blog Detail</a></li>
					  </ul>
                    </li> -->
				  <li><a class="m_tag" href="about.html">About Us</a></li>
				<li><a class="m_tag" href="contact.html">Contact</a></li>
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
	
<section id="center" class="center_list clearfix">
 <div class="container">
  <div class="row">
   <div class="center_list_1 clearfix">
    <div class="col-sm-9">
	 <div class="center_list_1l clearfix">
	  <div class="center_list_1li clearfix">
	   <h5 class="mgt"><a href="detail.html">Home</a>  /  Grid View</h5>
	   <h3>Grid View</h3>
	  </div>
	  <div class="feature_2 clearfix">

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

		<div class="col-sm-6 space_left">
						 <div class="feature_2im clearfix">
								<div class="feature_2im1 clearfix">
								<br>
							 <a href="detail.html"><img src="<?php echo $image;?>" class="iw" alt="abc" width="410" height="320"></a>
							</div>
								<div class="feature_2im2 clearfix">
								<br>
								 <h6 class="mgt"><a class="bg_1" href="detail.html">Featured</a></h6>
								 <h6 class="pull-right mgt"><a class="bg_2" href="detail.html">For Rent</a></h6>
								</div>
								<div class="feature_2im4 clearfix">
								 <div class="col-sm-6 space_left">
								   <h6><a class="bg_3" href="detail.html">Family Home</a></h6>
								 </div>
								 <div class="col-sm-6 feature_2im4r space_right">
								   <ul class="mgt">
									<li><a href="detail.html"><i class="fa fa-link"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-video-camera"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-photo"></i></a></li>
								   </ul>
								 </div>
								</div>
						 </div>
						 <div class="feature_2m_last clearfix">
						  <h4 class="mgt bold"><a href="detail.html"><?php echo $name;?></a></h4>
						  <p><i class="fa fa-map-marker"></i><?php echo $location;?></p><br>
						  <h6><i class="fa fa-hotel col_1"></i><?php echo $beds;?>Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i><?php echo $bathrooms;?>Bathrooms</span></h6>
						  <h6><i class="fa fa-object-group col_1"></i><?php echo $area;?>sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i><?php echo $parking;?> Garages</span></h6><br>
						  <h5 class="bold"><a href="detail.html">$ <?php echo $price;?> <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
						  <div class="feature_2m_last_i clearfix">
							<h6><a href="detail.html"><i class="fa fa-user"></i>user1 <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
						  </div>
						 </div>
						</div>
						<?php } ?>
		<!-- <div class="col-sm-6 space_left">
						 <div class="feature_2im clearfix">
								<div class="feature_2im1 clearfix">
							 <a href="detail.html"><img src="img/24.jpg" class="iw" alt="abc"></a>
							</div>
								<div class="feature_2im2 clearfix">
								 <h6 class="mgt"><a class="bg_1" href="detail.html">Featured</a></h6>
								 <h6 class="pull-right mgt"><a class="bg_4" href="detail.html">For Sale</a></h6>
								</div>
								<div class="feature_2im4 clearfix">
								 <div class="col-sm-6 space_left">
								   <h6><a class="bg_3" href="detail.html">Family Home</a></h6>
								 </div>
								 <div class="col-sm-6 feature_2im4r space_right">
								   <ul class="mgt">
									<li><a href="detail.html"><i class="fa fa-link"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-video-camera"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-photo"></i></a></li>
								   </ul>
								 </div>
								</div>
						 </div>
						 <div class="feature_2m_last clearfix">
						  <h4 class="mgt bold"><a href="detail.html">Lorem House Luxury Villa</a></h4>
						  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
						  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
						  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
						  <h5 class="bold"><a href="detail.html">$ 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
						  <div class="feature_2m_last_i clearfix">
							<h6><a href="detail.html"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
						  </div>
						 </div>
						</div> -->

      </div>
      <!-- <div class="feature_2 clearfix">
		<div class="col-sm-6 space_left">
						 <div class="feature_2im clearfix">
								<div class="feature_2im1 clearfix">
							 <a href="detail.html"><img src="img/25.jpg" class="iw" alt="abc"></a>
							</div>
								<div class="feature_2im2 clearfix">
								 <h6 class="mgt"><a class="bg_1" href="detail.html">Featured</a></h6>
								 <h6 class="pull-right mgt"><a class="bg_2" href="detail.html">For Rent</a></h6>
								</div>
								<div class="feature_2im4 clearfix">
								 <div class="col-sm-6 space_left">
								   <h6><a class="bg_3" href="detail.html">Family Home</a></h6>
								 </div>
								 <div class="col-sm-6 feature_2im4r space_right">
								   <ul class="mgt">
									<li><a href="detail.html"><i class="fa fa-link"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-video-camera"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-photo"></i></a></li>
								   </ul>
								 </div>
								</div>
						 </div>
						 <div class="feature_2m_last clearfix">
						  <h4 class="mgt bold"><a href="detail.html">Lorem House Luxury Villa</a></h4>
						  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
						  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
						  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
						  <h5 class="bold"><a href="detail.html">$ 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
						  <div class="feature_2m_last_i clearfix">
							<h6><a href="detail.html"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
						  </div>
						 </div>
						</div>
		<div class="col-sm-6 space_left">
						 <div class="feature_2im clearfix">
								<div class="feature_2im1 clearfix">
							 <a href="detail.html"><img src="img/26.jpg" class="iw" alt="abc"></a>
							</div>
								<div class="feature_2im2 clearfix">
								 <h6 class="mgt"><a class="bg_1" href="detail.html">Featured</a></h6>
								 <h6 class="pull-right mgt"><a class="bg_4" href="detail.html">For Sale</a></h6>
								</div>
								<div class="feature_2im4 clearfix">
								 <div class="col-sm-6 space_left">
								   <h6><a class="bg_3" href="detail.html">Family Home</a></h6>
								 </div>
								 <div class="col-sm-6 feature_2im4r space_right">
								   <ul class="mgt">
									<li><a href="detail.html"><i class="fa fa-link"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-video-camera"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-photo"></i></a></li>
								   </ul>
								 </div>
								</div>
						 </div>
						 <div class="feature_2m_last clearfix">
						  <h4 class="mgt bold"><a href="detail.html">Lorem House Luxury Villa</a></h4>
						  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
						  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
						  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
						  <h5 class="bold"><a href="detail.html">$ 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
						  <div class="feature_2m_last_i clearfix">
							<h6><a href="detail.html"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
						  </div>
						 </div>

						</div>
      </div> -->
	  <!-- <div class="feature_2 clearfix">
		<div class="col-sm-6 space_left">
						 <div class="feature_2im clearfix">
								<div class="feature_2im1 clearfix">
							 <a href="detail.html"><img src="img/36.jpg" class="iw" alt="abc"></a>
							</div>
								<div class="feature_2im2 clearfix">
								 <h6 class="mgt"><a class="bg_1" href="detail.html">Featured</a></h6>
								 <h6 class="pull-right mgt"><a class="bg_2" href="detail.html">For Rent</a></h6>
								</div>
								<div class="feature_2im4 clearfix">
								 <div class="col-sm-6 space_left">
								   <h6><a class="bg_3" href="detail.html">Family Home</a></h6>
								 </div>
								 <div class="col-sm-6 feature_2im4r space_right">
								   <ul class="mgt">
									<li><a href="detail.html"><i class="fa fa-link"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-video-camera"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-photo"></i></a></li>
								   </ul>
								 </div>
								</div>
						 </div>
						 <div class="feature_2m_last clearfix">
						  <h4 class="mgt bold"><a href="#">Lorem House Luxury Villa</a></h4>
						  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
						  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
						  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
						  <h5 class="bold"><a href="detail.html">$ 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
						  <div class="feature_2m_last_i clearfix">
							<h6><a href="detail.html"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
						  </div>
						 </div>
						</div>
		<div class="col-sm-6 space_left">
						 <div class="feature_2im clearfix">
								<div class="feature_2im1 clearfix">
							 <a href="detail.html"><img src="img/37.jpg" class="iw" alt="abc"></a>
							</div>
								<div class="feature_2im2 clearfix">
								 <h6 class="mgt"><a class="bg_1" href="detail.html">Featured</a></h6>
								 <h6 class="pull-right mgt"><a class="bg_4" href="detail.html">For Sale</a></h6>
								</div>
								<div class="feature_2im4 clearfix">
								 <div class="col-sm-6 space_left">
								   <h6><a class="bg_3" href="detail.html">Family Home</a></h6>
								 </div>
								 <div class="col-sm-6 feature_2im4r space_right">
								   <ul class="mgt">
									<li><a href="detail.html"><i class="fa fa-link"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-video-camera"></i></a></li>
									<li><a href="detail.html"><i class="fa fa-photo"></i></a></li>
								   </ul>
								 </div>
								</div>
						 </div>
						 <div class="feature_2m_last clearfix">
						  <h4 class="mgt bold"><a href="detail.html">Lorem House Luxury Villa</a></h4>
						  <p><i class="fa fa-map-marker"></i> Fst Su, 67 - Central Park North, OZD</p><br>
						  <h6><i class="fa fa-hotel col_1"></i> 4 Bedrooms <span class="pull-right"><i class="fa fa-building-o col_1"></i> 3 Bathrooms</span></h6>
						  <h6><i class="fa fa-object-group col_1"></i> 620 sq ft <span class="pull-right"><i class="fa fa-gear col_1"></i> 2 Garages</span></h6><br>
						  <h5 class="bold"><a href="detail.html">$ 130,000 <span class="pull-right"><i class="fa fa-exchange"></i> <i class="fa fa-share-alt"></i> <i class="fa fa-heart-o"></i></span></a></h5>
						  <div class="feature_2m_last_i clearfix">
							<h6><a href="detail.html"><i class="fa fa-user"></i> Eget Nulla <span class="pull-right"><i class="fa fa-calendar"></i> 3 months ago</span></a></h6>
						  </div>
						 </div>
						</div>
      </div> -->

	  <div class="product_1_last text-center clearfix">
	  <div class="col-sm-12">
	   <ul>
	    <li><a href="detail.html"><i class="fa fa-chevron-left"></i></a></li>
	    <li class="act"><a href="detail.html">1</a></li>
		<li><a href="detail.html">2</a></li>
		<li><a href="detail.html">3</a></li>
		<li><a href="detail.html">4</a></li>
		<li><a href="detail.html">5</a></li>
		<li><a href="detail.html">6</a></li>
		<li><a href="detail.html"><i class="fa fa-chevron-right"></i></a></li>
	   </ul>
	  </div>
	 </div>
	 </div>
	</div>
	<div class="col-sm-3 space_left">
	  <div class="center_list_1r clearfix"> 
	    <h4 class="mgt head_1">Search Property</h4>
	    <div class="center_main_1r clearfix">
     <h5 class="mgt col">Property Status</h5>
	 <select class="form-control" name="property">
		<option value="">Any Status</option>
		<option value="for-sale">For Sale</option>
		<option value="for-rent">For Rent</option>
		<!-- <option value="sold">Sold</option> -->
    </select>
	<h5 class="col">Property Type</h5>
	<select class="form-control" name="property">
		<option value="">Any Type</option>
		<option value="family-house">Family House</option>
		<option value="apartment">Apartment</option>
		<!-- <option value="condo">Condo</option> -->
    </select>
	<h5 class="col">Location</h5>
	<select class="form-control" name="Location">
		<option value="">Any Location</option>
		<option value="family-house">Mangalore</option>
		<option value="apartment">Banglore</option>
		<option value="condo">Mysore</option>
		<option value="condo">GulBarga</option>
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
	 <h5 class="col">Beds</h5>
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
	 <h5 class="col">Baths</h5>
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
   <h5 class="text-center"><a class="button_1 block" href="detail.html">SEARCH PROPERTY</a></h5>
   </div>
	  </div><br>
	  <div class="center_list_1r1 clearfix">
	    <h4 class="head_1 mgt">Recent Properties</h4>
		<div class="center_list_1r1i clearfix">
		 <a href="detail.html"><img src="img/38.jpg" alt="abc"></a>
		 <h5 class="bold mgt"><a href="detail.html">Family Home</a></h5>
		 <h6>$260,000</h6>
		</div>
		<div class="center_list_1r1i clearfix">
		 <a href="detail.html"><img src="img/39.jpg" alt="abc"></a>
		 <h5 class="bold mgt"><a href="detail.html">Family Home</a></h5>
		 <h6>$180,000</h6>
		</div>
		<div class="center_list_1r1i clearfix">
		 <a href="detail.html"><img src="img/40.jpg" alt="abc"></a>
		 <h5 class="bold mgt"><a href="detail.html">Family Home</a></h5>
		 <h6>$240,000</h6>
		</div>
	  </div><br>
	  <div class="center_list_1r1 clearfix">
	    <h4 class="head_1 mgt">Popular Tags</h4>
        <ul>
		 <li><a href="detail.html">House</a></li>
		 <li><a href="detail.html">Real Home</a></li>
		 <li><a href="detail.html">Baths</a></li>
		 <li><a href="detail.html">Beds</a></li>
		 <li><a href="detail.html">Garages</a></li>
		 <li><a href="detail.html">Family</a></li>
		 <li><a href="detail.html">Real Estates</a></li>
		 <li><a href="detail.html">Properties</a></li>
		 <li><a href="detail.html">Location</a></li>
		 <li><a href="detail.html">Price</a></li>
		</ul>
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
</body>
 
</html>
