
 <?php  
 require('db.php');
 $output = '';  

 if(isset($_POST["user_id"]))  
 {  

						 $query =    "SELECT * FROM `voltmeterp` WHERE `user_id` = '".$_POST["user_id"]."'" ;     
						 $result= mysqli_query($con, $query);
						 $row = mysqli_fetch_row($result);
						 
							  if(mysqli_num_rows($result)>0){

     $a = $_POST["user_id"];
  
	 include('voltmeter.php');
     
     include('indicator.php');
	
     include('graph.php');

     include('actions.php');
	 
	 include('configdata.php');
	 
     include('historytable.php');
	 
	 include('faultlogs.php');
	 
	 ?>
	 <style>


#toTopBtn {
    position: fixed;
    bottom: 50px;
    right: 30px;
    z-index: 100;
    padding: 21px;
    background-color:hsl(0, 0%, 60%,.8)
}

.js .cd-top--fade-out {
    opacity: .5
}

.js .cd-top--is-visible {
    visibility: visible;
    opacity: 1
}

.js .cd-top {
    visibility: hidden;
    opacity: 0;
    transition: opacity .3s, visibility .3s, background-color .3s
}

.cd-top {
    position: fixed;
    bottom: 20px;
    bottom: var(--cd-back-to-top-margin);
    right: 20px;
    right: var(--cd-back-to-top-margin);
    display: inline-block;
    height: 40px;
    height: var(--cd-back-to-top-size);
    width: 40px;
    width: var(--cd-back-to-top-size);
	border-radius:8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .05) !important;
    background: url(https://res.cloudinary.com/dxfq3iotg/image/upload/v1571057658/cd-top-arrow.svg) no-repeat center 50%;
    background-color: hsla(5, 76%, 62%, .8);
    background-color: hsla(var(--cd-color-3-h), var(--cd-color-3-s), var(--cd-color-3-l), 0.8)
}

	
	 </style>
	 <div class="text-right">
	<a href="#" id="toTopBtn" class="cd-top text-replace js-cd-top cd-top--is-visible cd-top--fade-out" data-abc="true"></a>
	 </div>	 
	 
	 <?php
							  }
							  
							else{
							?>
								<div class="content">
                     
					             <div class="text-center">
                                   <h1>No data </h1>
					             </div>
			       
				               </div> 
				 <?php
		                	}								
							  
	 
 }
	 
	 
	 ?>
	 

	<script>

  $(document).ready(function() {
           $(window).scroll(function() {
           if ($(this).scrollTop() > 20) {
                     $('#toTopBtn').fadeIn();
            } else {
                    $('#toTopBtn').fadeOut();
          }
       });

          $('#toTopBtn').click(function() {
      $("html, body").animate({
                   scrollTop: 0
             }, 1000);
          return false;
       });
});
</script>