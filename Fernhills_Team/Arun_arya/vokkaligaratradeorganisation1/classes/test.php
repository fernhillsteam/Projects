<?php

// Add New User By Admin
  public function addNewUserByAdmin($data){
	  
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
	$designation = $data['designation'];
    $password = $data['password'];
	$business = $data['business'];
	$biztype = $data['biztype'];
	$bizdesp = $data['description'];
	
	if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible text-white mt-3" role="alert">
                <span class="text-sm"><strong>Error !</strong> Input fields must not be Empty !</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
        return $msg;
    }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
        return $msg;

    }elseif(strlen($password) < 5) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
        return $msg;
    }elseif(!preg_match("#[0-9]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Your Password Must Contain At Least 1 Number !</div>';
        return $msg;
    }elseif(!preg_match("#[a-z]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Your Password Must Contain At Least 1 Number !</div>';
        return $msg;
    }elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Invalid email address !</div>';
        return $msg;
    }elseif ($checkUser == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Email already Exists, please try another Email... !</div>';
        return $msg;
    }else{
	//code for profile uploading
	       $profile_name = $_FILES['profile']['name'];
           $profile_size =$_FILES['profile']['size'];
           $profile_tmp =$_FILES['profile']['tmp_name'];
           $profile_type=$_FILES['profile']['type'];
		   $tmp_rofile = explode('.', $profile_name);
           $profile_ext = strtolower(end($tmp_rofile));
		   $profile=$profile_name;
		   
	//code for logo uploading	   
		   $logo_name = $_FILES['logo']['name'];
           $logo_size =$_FILES['logo']['size'];
           $logo_tmp =$_FILES['logo']['tmp_name'];
           $logo_type=$_FILES['logo']['type'];
		   $tmp_logo = explode('.', $logo_name);
           $logo_ext = strtolower(end($tmp_logo));
		   $logo=$logo_name;
		   
		    // Upload directory
           $upload_profile = "../profile/";
		   // Upload directory
          $upload_location = "../business/";
		   
		   // Get extension
           $ext1 = strtolower(pathinfo($profile_name, PATHINFO_EXTENSION
		   $ext2 = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));
		   // Valid image extension
		   $valid_ext= array("jpeg","jpg","png");
		   
		       if(in_array($ext1, $valid_ext)){
				   
				   if(in_array($ext2, $valid_ext)){
					   
					   // File path
                   $path = $upload_profile.$filename;
                   // Upload file
				   if(move_uploaded_file($profile_tmp,$path)){
					   
					   $sql = "INSERT INTO tbl_users(name, username,designation,profile,business,email, password, mobile, roleid) VALUES(:name, :username,:designation, :profile ,:business,:email, :password, :mobile, :roleid)";
                       $stmt = $this->db->pdo->prepare($sql);
                       $stmt->bindValue(':name', $name);
                       $stmt->bindValue(':username', $username);
	                   $stmt->bindValue(':designation', $designation);
	                   $stmt->bindValue(':profile', $profile);
	                   $stmt->bindValue(':business', $business);
                       $stmt->bindValue(':email', $email);
                       $stmt->bindValue(':password', SHA1($password));
                       $stmt->bindValue(':mobile', $mobile);
                       $stmt->bindValue(':roleid', $roleid);
                       $stmt->execute();
					   
					   
					   // Count total files
          $countfiles = count($_FILES['files']['name']);
                // Upload directory
          $upload_location = "../business/";
               // To store uploaded files path
          $files_arr = array();
              // Loop all files
         for($index = 0;$index < $countfiles;$index++){

                if(isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != ''){
                      // File name
                      $filename = $_FILES['files']['name'][$index];
                      $bizimage = $filename;
                         // Get extension
                      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        // Valid image extension
                        $valid_ext = array("png","jpeg","jpg");
                                  // Check extension
                                 if(in_array($ext, $valid_ext)){
                                         // File path
                                          $path = $upload_location.$filename;
                                             // Upload file
                                          if(move_uploaded_file($_FILES['files']['tmp_name'][$index],$path)){
                                                              $files_arr[] = $path;
															  
															  $sql = "INSERT INTO business(user_id,logo,bizimage,description) VALUES(:id, :logo,:bizimage, :description)";
                                                              $stmt = $this->db->pdo->prepare($sql);
															  $stmt->bindValue(':id', $userid);
															  $stmt->bindValue(':logo', $logo);
                                                              $stmt->bindValue(':bizimage', $bizimage);
                                                              $stmt->bindValue(':description', $description);
                                                              $stmt->execute();
	  
      
															  
                                                                   }
                                           }
                                      }
                             }
					   
				   
			   }else{
				   echo "image not upload";
			   }
					   
				   }else{
					    
						echo"not a valid logo"
				   }
				   

        }else{
			
			echo "not a valid profile pic";
		}
  

  
	}
  }
  ?>