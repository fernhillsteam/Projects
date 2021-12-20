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
				<form method="post" action="process.php">
					

		Program:<br>
		<input type="text" name="title">
		<br>
		Venue:<br>
		<input type="text" name="description">
		<br>
		Start Date:<br>
		<input type="text" name="sdate" value="">
		<br>
		End Date:<br>
		<input type="text" name="edate" value="">
		<br>
	  Select a time:<br>
    <input type="time" id="appt" name="appt">
    <select name="cars" id="cars">
    <option value="volvo">AM</option>
    <option value="saab">PM</option>
  </select>
    <br>
		Entry Fee:<br>
		<input type="text" name="cdate">
		<br><br>
		<input type="submit" name="save" value="submit">
		<input type="reset" name="clear" value="Clear">
	</form>
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
	
</script>
<?php include('footer.php');?>
