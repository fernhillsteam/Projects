<?php
include '../inc/header.php';

Session::CheckSession();
 ?>
   <?php			

   
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

  $register = $users->addNewUserByAdmin($_POST);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['slider_image'])) {
	
  $updateSliderImage = $users->updateSliderImgByAdmin($_POST);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
	
  $updateGallery = $users->createAlbumByAdmin($_POST);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gallery'])) {
	
  $updateGallery = $users->updateGalleryByAdmin($_POST);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['album'])) {
	
  $updateGallery = $users->updateAlbumByAdmin($_POST);

}

if (isset($_GET['remove'])) {
	
  $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  
  $remove = $users->deleteSliderImgByAdmin($remove);
}
if (isset($register)) {
  echo $register;
}


 ?>