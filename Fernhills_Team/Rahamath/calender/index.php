<?php 
session_start();
include('header.php');
?>
<title>calender</title>

<link rel="stylesheet" href="css/calendar.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  	window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
  </script>
<div class="container">
<?php 
if (isset($_SESSION['status'])) 
{

	?>
<div class="alert alert-warning" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Hey!</strong><?php echo $_SESSION['status']; ?>
  </div>

    
	<?php
	
	unset($_SESSION['status']);
}
 ?>		
	<h2>Calendar</h2>
	<div class="page-header">
		<div class="pull-right form-inline">
			<div class="btn-group">
				<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
				<button class="btn btn-default" data-calendar-nav="today">Today</button>
				<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
			</div>
			<div class="btn-group">
				<button class="btn btn-warning" data-calendar-view="year">Year</button>
				<button class="btn btn-warning active" data-calendar-view="month">Month</button>
				<button class="btn btn-warning" data-calendar-view="week">Week</button>
				<button class="btn btn-warning" data-calendar-view="day">Day</button>
			</div>
		</div>
		<h3></h3>
		<!-- <small>To see example with events navigate to Februray 2018</small> -->
	</div>
	<div class="row">
		<div class="col-md-9">
			<div id="showEventCalendar"></div>
		</div>
		<!-- <div class="col-md-3">
			<h4>All Events List</h4>
			<ul id="eventlist" class="nav nav-list"></ul>
		</div> -->
		<div class="col-md-3">
			<h4>Create an event</h4>
			<ul class="nav nav-list">
				<form class="row g-3" method="POST" action="process.php">
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Program</label>
    <input type="text" name="title" class="form-control" id="inputAddress2" placeholder="program name">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Venue</label>
    <input type="text" name="description" class="form-control" id="inputAddress2" placeholder="venue">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Start Date</label>
    <input type="date" name="sdate" class="form-control" id="dateTime" value="" placeholder="Event Date">
  </div>
<div class="col-12">
    
    <input type="hidden" name="edate" class="form-control" id="edate" value="" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Start-Time</label>
    <input type="time" class="form-control" name="stime" id="" placeholder="Start Time">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">End-Time</label>
    <input type="time" class="form-control" name="etime" id="" placeholder="End Time">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Entry-Fee</label>
    <input type="text" name="efee" class="form-control" id="" placeholder="entry fee">
  </div>
  <!-- <div class="col-12">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div> -->
  
  <br>
  <div class="col-12">
    <button type="submit" name="save" onclick="get_value()" value="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
<!-- <form class="row g-3">
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Program</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Venue</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Start Date</label>
    <input type="date" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
<div class="col-12">
    
    <input type="hidden" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Start</label>
    <input type="text" class="form-control" id="inputEmail4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">end</label>
    <input type="text" class="form-control" id="inputPassword4">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">entry fee</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="col-12">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  
  <br>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form> -->

			</ul>
		</div>
	</div>	
	<!-- <div style="margin:50px 0px 0px 0px;">
		<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.phpzag.com/create-event-calendar-with-jquery-php-and-mysql/">Back to Tutorial</a>		
	</div> -->
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/events.js"></script>

	<script type="text/javascript">
         $('#dateTime').ejDateTimePicker({
       dateTimeFormat: "dddd, MMMM dd, yyyy hh:mm:ss tt",
       timePopupWidth: "150px",
       timeDisplayFormat: "hh:mm:ss tt",
       width: '300px'
    });
         $('#edate').ejDateTimePicker({
       dateTimeFormat: "dddd, MMMM dd, yyyy hh:mm:ss tt",
       timePopupWidth: "150px",
       timeDisplayFormat: "hh:mm:ss tt",
       width: '300px'
    });
    </script>
</script>
<script type="text/javascript">
	window.onload = function() {
    var src = document.getElementById("dateTime"),
        dst = document.getElementById("edate");
    src.addEventListener('input', function() {
        dst.value = src.value;
    });
};
</script>
<?php include('footer.php');?>
