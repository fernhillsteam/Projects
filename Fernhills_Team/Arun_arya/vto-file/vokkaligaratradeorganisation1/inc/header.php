<?php
$filepath = realpath(dirname(__FILE__));
include_once $filepath."./../lib/Session.php";
Session::init();



spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});


$users = new Users();

?>



<?php


if (isset($_GET['action']) && $_GET['action'] == 'adminlogout') {
  // Session::set('logout', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  // <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  // <strong>Success !</strong> You are Logged Out Successfully !</div>');
  Session::admindestroy();
}

if (isset($_GET['action']) && $_GET['action'] == 'userlogout') {
  // Session::set('logout', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  // <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  // <strong>Success !</strong> You are Logged Out Successfully !</div>');
  Session::userdestroy();
}

 ?>


      
