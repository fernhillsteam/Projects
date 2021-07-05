<?php
   session_start();
   if(!isset($_SESSION["mobilenumber"])){
   header("Location: login.php");
   exit();
   }
?>
