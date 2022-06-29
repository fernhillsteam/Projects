<?php

include '../lib/Database.php';
include_once '../lib/Session.php';


class Users{


  // Db Property
  private $db;
  private $errors =[];
  private $id='';
  

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

  // Date formate Method
   public function formatDate($date){
     // date_default_timezone_set('Asia/Dhaka');
      $strtime = strtotime($date);
    return date('Y-m-d', $strtime);
   }


// Check Exist Admin Method
  public function checkExistAdminname($username){
    $sql = "SELECT username from  admin WHERE username = :username";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
     $stmt->execute();
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  }


  // Check Exist User Method
  public function checkExistUsername($username){
    $sql = "SELECT username from  tbl_users WHERE username = :username";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
     $stmt->execute();
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  }



  // User Registration Method
  public function userRegistration($data){
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
    $password = $data['password'];
	
	

    $checkUser = $this->checkExistUsername($username);

    if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Please, User Registration field must not be Empty !</div>';
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
    }elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
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

      $sql = "INSERT INTO tbl_users(name, username, email, password, mobile, roleid) VALUES(:name, :username, :email, :password, :mobile, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', SHA1($password));
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }



    }





  }
  // Add New User By Admin
  /*public function addNewUserByAdmin($data){
	  
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
	
	
	//code for profile uploading
	if($_FILES['profile']['name']){
		
	       $profile_name = $_FILES['profile']['name'];
           $profile_size =$_FILES['profile']['size'];
           $profile_tmp =$_FILES['profile']['tmp_name'];
           $profile_type=$_FILES['profile']['type'];
		   $tmp_rofile = explode('.', $profile_name);
           $profile_ext = strtolower(end($tmp_rofile));
		   $profile=$profile_name;
		   
         }
		 
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($profile_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($profile_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(true){
         move_uploaded_file($profile_tmp,"../profile/".$profile_name);
		 $profile=$profile_name;
      }

    $checkUser = $this->checkExistUsername($username);

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
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
        echo"<script>location.href='members.php';</script>";
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }



    }


    //code for logo uploading
	if($_FILES['logo']['name']){
		
	       $logo_name = $_FILES['logo']['name'];
           $logo_size =$_FILES['logo']['size'];
           $logo_tmp =$_FILES['logo']['tmp_name'];
           $logo_type=$_FILES['logo']['type'];
		   $tmp_logo = explode('.', $logo_name);
           $logo_ext = strtolower(end($tmp_logo));
		   $logo=$logo_name;
	}
		 
      $extensions= array("jpeg","jpg","png");
	  // check size
	   
      if($logo_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
	    // Check extension
          if( in_array($logo_ext,$extensions) ){
     // Upload file
                if(move_uploaded_file($logo_tmp,"../business/".$logo_name)){
					
					if($_FILES['files']['name']){
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
   
		}	 
	}
  }

  }*/
  

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
	
	
	$checkUser = $this->checkExistUsername($username);
	
	if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible text-white mt-3" role="alert">
                <span class="text-sm"><strong>Error !</strong> Input fields must not be Empty !</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
         $msg;
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
          $upload_logo = "../business/";
		   
		   // Get extension
           $ext1 = strtolower(pathinfo($profile_name, PATHINFO_EXTENSION));
		   $ext2 = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));
		   // Valid image extension
		   $valid_ext= array("jpeg","jpg","png");
		   
		       if(in_array($ext1, $valid_ext)){
				   
				   if(in_array($ext2, $valid_ext)){
					   
					   // File path
                   $path = $upload_profile.$profile_name;
				   $path1 = $upload_logo.$logo_name;
                   // Upload file
				   if(move_uploaded_file($profile_tmp,$path)){
					   
					   if(move_uploaded_file($logo_tmp,$path1)){
					   
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
					   
					   $id = $this->db->pdo->lastInsertId();
					   
	                   $sql1 = "INSERT INTO business(user_id,logo,business,biztype,description) VALUES( :id,:logo,:business,:biztype,:description)";
                       $stmt1 = $this->db->pdo->prepare($sql1);
	                   $stmt1->bindValue(':id', $id);
					   $stmt1->bindValue(':logo', $logo);
					   $stmt1->bindValue(':business', $business);
			           $stmt1->bindValue(':biztype', $biztype);
                       $stmt1->bindValue(':description', $bizdesp);
                       $stmt1->execute();
	 				   
                       }else{
						   
						   echo "logo not uploaded";
					   }
        }else{
			
			echo "profile pic not uploaded";
		}
  

  
	}else{
			
			echo "not a valid logo";
		}
  }else{
			
			echo "not a valid profile pic";
		}
 
	}
	
  }	
	
  // Select All User Method
  public function selectAllUserData(){
    $sql = "SELECT * FROM tbl_users ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  // User login Autho Method
  public function userLoginAutho($username, $password){
    $password = SHA1($password);
    $sql = "SELECT * FROM tbl_users WHERE username = :username and password = :password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  
  
  // User login Autho Method
  public function adminLoginAutho($username, $password){
    $password = SHA1($password);
    $sql = "SELECT * FROM admin WHERE username = :username and password = :password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  
  // Check User Account Satatus
  public function CheckActiveUser($username){
    $sql = "SELECT * FROM tbl_users WHERE username = :username and isActive = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }


// Check Admin Account Satatus
  public function CheckActiveAdmin($username){
    $sql = "SELECT * FROM admin WHERE username = :username and isActive = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

    
	public function validateUsername($username){
		
		$val = trim($username);
		if($val == ""){
			$this->addError('username','username cannot be empty'); 
		}elseif(!preg_match('/^[a-zA-Z]{3,6}$/',$val)){
			$this->addError('username','username must be 3-6 chars');
	    }else{
			return TRUE;
		}
		
	}
	
	public function validatePassword($password){
		
		$val =trim($password);
		 
		
		if($val == ""){
			$this->addError('password','password cannot be empty');
			 
		}elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/',$val)){
			$this->addError('password','Minimum 8 characters, at least 1 letter and 1 number');
	    }else{
			return TRUE;
		}
		
		
	}
	
	
	
	public function addError($key,$val){
		$this->errors[$key] = $val;
		
	}


 // Admin Login Authotication Method
    public function adminLoginAuthotication($data){
      $username = $data['username'];
      $password = $data['password'];

	  
      $validUser = $this->validateUsername($username);
	  $validPassword = $this->validatePassword($password);
	  
	  if($validUser && $validPassword){
		  
		  $checkAdmin = $this->checkExistAdminname($username);
	               
		if ($checkAdmin == FALSE) {
              $this->addError('checkAdmin','you are not an admin');
            }else{

        $logResult = $this->adminLoginAutho($username, $password);
        $chkActive = $this->CheckActiveUser($username);

        if ($chkActive == TRUE) {
			
			$this->addError('status','Your account is Diactivated, Contact with Admin');
			

        }elseif ($logResult) {

          Session::init();
          Session::set('login', TRUE);
          Session::set('id', $logResult->id);
          Session::set('roleid', $logResult->roleid);
          Session::set('name', $logResult->name);
          Session::set('email', $logResult->email);
          Session::set('username', $logResult->username);
		 
          echo "<script>location.href='dashboard.php';</script>";

        }else{
			
			$this->addError('notmatch','Username or Password did not Matched !');
         
        }
      }
	  }
      return $this->errors;
      
    }
	
	
	// User Login Authotication Method
    public function userLoginAuthotication($data){
      $username = $data['username'];
      $password = $data['password'];

	  
      $validUser = $this->validateUsername($username);
	  $validPassword = $this->validatePassword($password);
	  
	  if($validUser && $validPassword){
		  
		  $checkUser = $this->checkExistUsername($username);
	               
		if ($checkUser == FALSE) {
              $this->addError('checkAdmin','you are not an Member');
            }else{

        $logResult = $this->userLoginAutho($username, $password);
        $chkActive = $this->CheckActiveUser($username);

        if ($chkActive == TRUE) {
			
			$this->addError('status','Your account is Diactivated, Contact with Admin');
			

        }elseif ($logResult) {

          Session::init();
          Session::set('login', TRUE);
          Session::set('id', $logResult->id);
          Session::set('roleid', $logResult->roleid);
          Session::set('name', $logResult->name);
          Session::set('email', $logResult->email);
          Session::set('username', $logResult->username);
		 
          echo "<script>location.href='dashboard.php';</script>";

        }else{
			
			$this->addError('notmatch','Username or Password did not Matched !');
         
        }
      }
	  }
      return $this->errors;
      
    }


   // Get TotalMember Method
    public function getTotalMember(){
	  $sql = "SELECT COUNT(*) FROM tbl_users";
	  $stmt = $this->db->pdo->prepare($sql);
      $stmt->execute();
	  return $count = $stmt->fetchColumn();
    }
	
	// Get ActiveMember Method
    public function getActiveMember(){
	  $sql = "SELECT COUNT(*) FROM tbl_users WHERE isActive = 0 ";
	  $stmt = $this->db->pdo->prepare($sql);
      $stmt->execute();
	  return $count = $stmt->fetchColumn();
    }
	
	// Get ActiveMember Method
    public function getDeactiveMember(){
	  $sql = "SELECT COUNT(*) FROM tbl_users WHERE isActive = 1 ";
	  $stmt = $this->db->pdo->prepare($sql);
      $stmt->execute();
	  return $count = $stmt->fetchColumn();
    }
	
    // Get Single User Information By Id Method
    public function getUserInfoById($userid){
      $sql = "SELECT * FROM tbl_users WHERE id = :id LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }


    }



  //
  
  //updateSliderImgByAdmin
  //upload slider image by Admin  Method
    public function updateSliderImgByAdmin(){
		
		
		if($_FILES['image']['name']){
                 // Count total files
          $countfiles = count($_FILES['image']['name']);
                // Upload directory
          $upload_location = "../../assets/images/slider/";
               // To store uploaded files path
          $files_arr = array();
              // Loop all files
         for($index = 0;$index < $countfiles;$index++){

                if(isset($_FILES['image']['name'][$index]) && $_FILES['image']['name'][$index] != ''){
                      // File name
                      $filename = $_FILES['image']['name'][$index];
                      $image = $filename;
					  
					  
					  
                         // Get extension
                      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        // Valid image extension
                        $valid_ext = array("png","jpeg","jpg");
                                  // Check extension
                                 if(in_array($ext, $valid_ext)){
									 
									 //width and height
					  $image_info = getimagesize($_FILES['image']['tmp_name'][$index]);
                      $image_width = $image_info[0];
                      $image_height = $image_info[1];
					  
					  if($image_width == 1900  && $image_height==750){
                                         // File path
                                          $path = $upload_location.$filename;
										  
										  // Check if file already exists
                                                if (file_exists($path)) {
														   echo "<script>location.href='./slider.php';</script>";
                                             }else{
												 
															  $sql = "SELECT COUNT(*) FROM slider_images";
	                                                          $stmt = $this->db->pdo->prepare($sql);
                                                              $stmt->execute();
	                                                          $rowcount = $stmt->fetchColumn();
															
	                                                       if($rowcount!=5){
															   
															   move_uploaded_file($_FILES['image']['tmp_name'][$index],$path);
												 
                                                                            $files_arr[] = $path;
															   
															 $sql = "INSERT INTO slider_images(slider) VALUES(:slider)";
                                                              $stmt = $this->db->pdo->prepare($sql);
                                                              $stmt->bindValue(':slider', $image);
															  $result =$stmt->execute();
															 
                                                             $this->addError('upload','<div class="alert alert-success text-center" role="alert">
															 images Uploaded Successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                         <span aria-hidden="true">&times;</span></button></div>');
														        }else{
																	   $this->addError('upload','<div class="alert alert-danger text-center" role="alert">
																	   images upload limited upto 5!
																	   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                                   <span aria-hidden="true">&times;</span></button></div>');
																   }
                                                      }
                                           }else{
						                            $this->addError('resolution','<div class="alert alert-danger text-center" role="alert">
													 images not a Valid Resolution!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                 <span aria-hidden="true">&times;</span></button></div>');
					                              }
										   
										   
								 }else{
                                                     $this->addError('invalid','<div class="alert alert-danger text-center" role="alert">
													 images not Valid!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                 <span aria-hidden="true">&times;</span></button></div>');
										        }
										   
					                       }

                                      }
                             }	
return $this->errors;							 
   
		}

      

		
  
  
  // Delete Slider image by Admin Method
    public function deleteSliderImgByAdmin($remove){
	  
                 $sql = "SELECT slider FROM slider_images WHERE sl_no = :sl_no";
                 $stmt = $this->db->pdo->prepare($sql);
                 $stmt->bindValue(':sl_no', $remove);
	             $result =$stmt->execute();
				 $row = $stmt->fetch();
				 $fetchImgTitleName = $row['slider'];
				 $createDeletePath = "../../assets/images/slider/".$fetchImgTitleName;
	  
		if(unlink($createDeletePath))
		{
			$sql = "DELETE FROM slider_images WHERE sl_no = :sl_no";
			$stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':sl_no', $remove);
	        $rDelete =$stmt->execute();	
			
			if($rDelete)
			{
				
				 echo "<script>location.href='./slider.php';</script>";
				 $this->addError('remove','<div class="alert alert-danger text-center" role="alert">
                                      image Deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                   <span aria-hidden="true">&times;</span></button></div>');
				
			}
			
		}
		else
		{
			$this->addError('remove','<div class="alert alert-danger text-center" role="alert">
                                      image not Deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                   <span aria-hidden="true">&times;</span></button></div>');
		}
		//echo "<script>location.href='./slider.php';</script>";
		
		return $this->errors;

    }
	
	
	// Delete Slider image by Admin Method
    public function deleteAlbumImgByAdmin($remove){
	  
                 $sql = "SELECT * FROM gallery WHERE sl_no = :sl_no";
                 $stmt = $this->db->pdo->prepare($sql);
                 $stmt->bindValue(':sl_no', $remove);
	             $result =$stmt->execute();
				 $row = $stmt->fetch();
				 $fetchId = $row['album_id'];
				 $fetchImgTitleName = $row['image'];
				 $createDeletePath = "../../assets/images/gallery/album_".$fetchId."/".$fetchImgTitleName;
	  
		if(unlink($createDeletePath))
		{
			$sql = "DELETE FROM gallery WHERE sl_no = :sl_no";
			$stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':sl_no', $remove);
	        $rDelete =$stmt->execute();	
			
			if($rDelete)
			{
				
				 echo "<script>location.href='./gallery.php';</script>";
				 $this->addError('remove','<div class="alert alert-danger text-center" role="alert">
                                      image Deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                   <span aria-hidden="true">&times;</span></button></div>');
				
			}
			
		}
		else
		{
			$this->addError('remove','<div class="alert alert-danger text-center" role="alert">
                                      image not Deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                   <span aria-hidden="true">&times;</span></button></div>');
		}
		//echo "<script>location.href='./slider.php';</script>";
		
		return $this->errors;

    }
	
	//delete title imgs
	
	public function deleteTitleImgByAdmin($remove){
				 $sql = "DELETE FROM album_list WHERE id = :id";
			     $stmt = $this->db->pdo->prepare($sql);
                 $stmt->bindValue(':id', $remove);
	             $rDelete =$stmt->execute();	
				 $createDeletePath = "../../assets/images/gallery/album_".$remove;
	             $createDeletePath = escapeshellarg($createDeletePath); 
				 exec("rmdir /s /q $createDeletePath");


			$sql = "DELETE FROM gallery WHERE album_id = :id";
			$stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':id', $remove);
	        $rDelete =$stmt->execute();	
			
			if($rDelete)
			{
				
				 echo "<script>location.href='./gallery.php';</script>";
				 $this->addError('remove','<div class="alert alert-danger text-center" role="alert">
                                      image Deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                   <span aria-hidden="true">&times;</span></button></div>');
				
			}
		
		else
		{
			$this->addError('remove','<div class="alert alert-danger text-center" role="alert">
                                      image not Deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                   <span aria-hidden="true">&times;</span></button></div>');
		}
		//echo "<script>location.href='./slider.php';</script>";
		
		return $this->errors;

    }
  
  // Select All Slider Images Method
  public function selectAllSliderImg(){
    $sql = "SELECT * FROM slider_images ORDER BY sl_no DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  
  
   //upload Gallery image by Admin  Method
    public function updateGalleryByAdmin($data){
		
		$event = $data['event'];
        $date= $data['date'];
        $desp = $data['desp'];
		
		if($_FILES['gallery']['name']){
                 // Count total files
          $countfiles = count($_FILES['gallery']['name']);
                // Upload directory
          $upload_location = "../../assets/images/gallery/".$event."/";
		  
		  # create directory if not exists in upload/ directory
                           
                if(!is_dir($upload_location)){
					
					mkdir($upload_location, 777, TRUE );
				}
               // To store uploaded files path
          $files_arr = array();
		  
              // Loop all files
         for($index = 0;$index < $countfiles;$index++){

                if(isset($_FILES['gallery']['name'][$index]) && $_FILES['gallery']['name'][$index] != ''){
                      // File name
                      $filename = $_FILES['gallery']['name'][$index];
                      $image = $filename;
					  
                         // Get extension
                      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        // Valid image extension
                      $valid_ext = array("png","jpeg","jpg");
                                  // Check extension
                                 if(in_array($ext, $valid_ext)){
									 
									 //width and height
					  $image_info = getimagesize($_FILES['gallery']['tmp_name'][$index]);
                      $image_width = $image_info[0];
                      $image_height = $image_info[1];
					  
					  if($image_width == 1280  && $image_height==853){
                                         // File path
                                          $path = $upload_location.$filename;
										 
															   if(move_uploaded_file($_FILES['gallery']['tmp_name'][$index],$path)){
												 
                                                                            $files_arr[] = $path;
															   
															 $sql = "INSERT INTO gallery(image,event,date,description) VALUES(:image,:event,:date,:description)";
                                                              $stmt = $this->db->pdo->prepare($sql);
                                                              $stmt->bindValue(':image', $image);
															  $stmt->bindValue(':event', $event);
															  $stmt->bindValue(':date', $date);
															  $stmt->bindValue(':description', $desp);
															  $result =$stmt->execute();
															 
                                                             $this->addError('upload','<div class="alert alert-success text-center" role="alert">
															 images Uploaded Successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                         <span aria-hidden="true">&times;</span></button></div>');
															 
															 
														        }else{
																	   $this->addError('upload','<div class="alert alert-danger text-center" role="alert">
																	   images not upload!
																	   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                                   <span aria-hidden="true">&times;</span></button></div>');
																   }
										   
										   
					                       
                                      }else{
						                            $this->addError('resolution','<div class="alert alert-danger text-center" role="alert">
													 images not a Valid Resolution!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                 <span aria-hidden="true">&times;</span></button></div>');
					                              }
									  
		                           	  
								 
                             }else{
                                                     $this->addError('invalid','<div class="alert alert-danger text-center" role="alert">
													 images not Valid!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                 <span aria-hidden="true">&times;</span></button></div>');
										        }
												
												
				}
				
		 }
		
		
		}
return $this->errors;							 
   
		}
  
  // Select All Slider Images Method
  public function selectAllGalleryImg($album_id){
    $sql = "SELECT * FROM gallery WHERE album_id = :id ORDER BY sl_no DESC";
    $stmt = $this->db->pdo->prepare($sql);
	$stmt->bindValue(':id', $album_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  
  // User Registration Method
  public function createAlbumByAdmin($data){
    $title = $data['title'];
    $date = $data['date'];
    $venue = $data['venue'];
    $desp = $data['desp'];
	
	

    if ($title == "" || $date == "" || $venue == "" || $desp == "" ) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Please, User Registration field must not be Empty !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO album_list(title, date, venue, description) VALUES(:title, :date, :venue, :desp)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':title', $title);
      $stmt->bindValue(':date', $date);
      $stmt->bindValue(':venue', $venue);
      $stmt->bindValue(':desp', $desp);
      $result = $stmt->execute();
      if ($result) {
		echo "<script>location.href='./gallery.php';</script>";
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }



    }



  }
  
  
  // User Registration Method
  public function updateTitleAlbumByAdmin($data){
    $title = $data['title'];
    $date = $data['date'];
    $venue = $data['venue'];
    $desp = $data['desp'];
	$id = $data['id'];
	

    if ($title == "" || $date == "" || $venue == "" || $desp == "" ) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Please, User Registration field must not be Empty !</div>';
        return $msg;
    }else{

      $sql = "UPDATE  album_list SET title=:title, date=:date, venue=:venue, description=:desp WHERE id=:id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':title', $title);
      $stmt->bindValue(':date', $date);
      $stmt->bindValue(':venue', $venue);
      $stmt->bindValue(':desp', $desp);
	  $stmt->bindValue(':id', $id);
      $result = $stmt->execute();
      if ($result) {
		echo "<script>location.href='./gallery.php';</script>";
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }



    }



  }
 
 //upload Gallery image by Admin  Method
    public function updateAlbumByAdmin($data){
		
		$album_id = $data['album_id'];
		
		if($_FILES['album']['name']){
                 // Count total files
          $countfiles = count($_FILES['album']['name']);
                // Upload directory
          $upload_location = "../../assets/images/gallery/album_".$album_id."/";
		  
		  # create directory if not exists in upload/ directory
                           
                if(!is_dir($upload_location)){
					
					mkdir($upload_location, 777, TRUE );
				}
               // To store uploaded files path
          $files_arr = array();
		  
              // Loop all files
         for($index = 0;$index < $countfiles;$index++){

                if(isset($_FILES['album']['name'][$index]) && $_FILES['album']['name'][$index] != ''){
                      // File name
                      $filename = $_FILES['album']['name'][$index];
                      $image = $filename;
					  
                         // Get extension
                      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        // Valid image extension
                      $valid_ext = array("png","jpeg","jpg");
                                  // Check extension
                                 if(in_array($ext, $valid_ext)){
									 
									 //width and height
					  $image_info = getimagesize($_FILES['album']['tmp_name'][$index]);
                      $image_width = $image_info[0];
                      $image_height = $image_info[1];
					  
					  if($image_width == 1280  && $image_height==853){
                                         // File path
                                          $path = $upload_location.$filename;
										 
															   if(move_uploaded_file($_FILES['album']['tmp_name'][$index],$path)){
												 
                                                                            $files_arr[] = $path;
															   
															 $sql = "INSERT INTO gallery(album_id, image) VALUES(:album_id,:image)";
                                                              $stmt = $this->db->pdo->prepare($sql);
															  $stmt->bindValue(':album_id', $album_id);
                                                              $stmt->bindValue(':image', $image);
															  $result =$stmt->execute();
															 		echo "<script>location.href='./gallery.php';</script>";
																
                                                             $this->addError('upload','<div class="alert alert-success text-center" role="alert">
															 images Uploaded Successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                         <span aria-hidden="true">&times;</span></button></div>');
															 
															 
														        }else{
																	   $this->addError('upload','<div class="alert alert-danger text-center" role="alert">
																	   images not upload!
																	   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                                   <span aria-hidden="true">&times;</span></button></div>');
																   }
										   
										   
					                       
                                      }else{
						                            $this->addError('resolution','<div class="alert alert-danger text-center" role="alert">
													 images not a Valid Resolution!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                 <span aria-hidden="true">&times;</span></button></div>');
					                              }
									  
		                           	  
								 
                             }else{
                                                     $this->addError('invalid','<div class="alert alert-danger text-center" role="alert">
													 images not Valid!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                                 <span aria-hidden="true">&times;</span></button></div>');
										        }
												
												
				}
				
		 }
		
		
		}
return $this->errors;							 
   
		}
  
  // Select All Album Images Method
  public function selectAllAlbum(){
    $sql = "SELECT * FROM album_list  ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  
  //   Get Single User Information By Id Method
    public function updateUserByAdmin($userid, $data){
      $name = $data['name'];
      $username = $data['username'];
      $email = $data['email'];
      $mobile = $data['mobile'];
      $roleid = $data['roleid'];
	  $designation = $data['designation'];

      

      if ($name == "" || $username == ""|| $email == "" || $mobile == ""  ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Input Fields must not be Empty !</div>';
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


      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Invalid email address !</div>';
          return $msg;
      }else{
		  
		  if(!empty($_FILES['profile']['name'])) {//new image uploaded
		  
		  //code for profile uploading
	       $profile_name = $_FILES['profile']['name'];
           $profile_size =$_FILES['profile']['size'];
           $profile_tmp =$_FILES['profile']['tmp_name'];
           $profile_type=$_FILES['profile']['type'];
		   $tmp_rofile = explode('.', $profile_name);
           $profile_ext = strtolower(end($tmp_rofile));
		   $profile=$profile_name;
		       // Upload directory
           $upload_profile = "../profile/";
		   
		   // Get extension
           $ext1 = strtolower(pathinfo($profile_name, PATHINFO_EXTENSION));
		   // Valid image extension
		   $valid_ext= array("jpeg","jpg","png");
		   
		   if(in_array($ext1, $valid_ext)){
			   if($profile_size < 2097152){
				   move_uploaded_file($profile_tmp,$upload_profile.$profile_name);
				   
				     $sql = "UPDATE tbl_users SET 
                     name = :name,
                     username = :username,
		             profile = :profile,
                     email = :email,
                     mobile = :mobile,
                     roleid = :roleid,
		             designation =  :designation
                     WHERE id = :id";
                     $stmt= $this->db->pdo->prepare($sql);
                     $stmt->bindValue(':name', $name);
                     $stmt->bindValue(':username', $username);
		             $stmt->bindValue(':profile', $profile);
                     $stmt->bindValue(':email', $email);
                     $stmt->bindValue(':mobile', $mobile);
                     $stmt->bindValue(':roleid', $roleid);
		             $stmt->bindValue(':designation', $designation);
                     $stmt->bindValue(':id', $userid);
                     $result = $stmt->execute();

        if ($result) {
		  echo "<script>location.href='./members.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='./members.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');


        }
				   
				   
				   
			   }else{
				   
			   }
		   }else{
			   
		   }
	
}else{
   $sql = "UPDATE tbl_users SET 
          name = :name,
          username = :username,
          email = :email,
          mobile = :mobile,
          roleid = :roleid,
		  designation =  :designation
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':name', $name);
          $stmt->bindValue(':username', $username);
          $stmt->bindValue(':email', $email);
          $stmt->bindValue(':mobile', $mobile);
          $stmt->bindValue(':roleid', $roleid);
		  $stmt->bindValue(':designation', $designation);
          $stmt->bindValue(':id', $userid);
          $result = $stmt->execute();

        if ($result) {
		  echo "<script>location.href='./members.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='./members.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');


        }
}
	  
		}

      }

//   Get Single User Information By Id Method
    public function updateUserBizByAdmin($userid, $data){
     	$business = $data['business'];
	    $biztype = $data['biztype'];
	    $bizdesp = $data['description'];

     
		   
		    if(!empty($_FILES['logo']['name'])) {//new image uploaded
		  
		  //code for profile uploading
	       $logo_name = $_FILES['logo']['name'];
           $logo_size =$_FILES['logo']['size'];
           $logo_tmp =$_FILES['logo']['tmp_name'];
           $logo_type=$_FILES['logo']['type'];
		   $tmp_logo = explode('.', $logo_name);
           $logo_ext = strtolower(end($tmp_logo));
		   $logo=$logo_name;
		       // Upload directory
           $upload_logo = "../business/";
		   
		   // Get extension
           $ext = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));
		   // Valid image extension
		   $valid_ext= array("jpeg","jpg","png");
		   
		   if(in_array($ext, $valid_ext)){
			   if($logo_size < 2097152){
				   move_uploaded_file($logo_tmp,$upload_logo.$logo_name);
				   
				     $sql = "UPDATE business SET 
                     business = :business,
                     biztype = :biztype,
		             description = :description,
                     logo = :logo
                     WHERE user_id = :id";
                     $stmt= $this->db->pdo->prepare($sql);
                     $stmt->bindValue(':business', $business);
                     $stmt->bindValue(':biztype', $biztype);
		             $stmt->bindValue(':description', $bizdesp);
		             $stmt->bindValue(':logo', $logo);
                     $stmt->bindValue(':id', $userid);
                     $result = $stmt->execute();
					 
					 $sql1 = "UPDATE tbl_users SET 
                     business = :business
                     WHERE user_id = :id";
                     $stmt1= $this->db->pdo->prepare($sql1);
                     $stmt1->bindValue(':business', $business);
                     $stmt1->bindValue(':id', $userid);
                     $result1 = $stmt1->execute();
					 

        if ($result1) {
		  echo "<script>location.href='./members.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='./members.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');


        }
				   
				   
				   
			   }else{
				   
			   }
		   }else{
			   
		   }
	
}else{
  $sql = "UPDATE business SET 
          business = :business,
          biztype = :biztype,
		  description = :description
          WHERE user_id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':business', $business);
          $stmt->bindValue(':biztype', $biztype);
		  $stmt->bindValue(':description', $bizdesp);
          $stmt->bindValue(':id', $userid);
          $result = $stmt->execute();
		  
		  $sql1 = "UPDATE tbl_users SET 
                     business = :business
                     WHERE id = :id";
                     $stmt1= $this->db->pdo->prepare($sql1);
                     $stmt1->bindValue(':business', $business);
                     $stmt1->bindValue(':id', $userid);
                     $result1 = $stmt1->execute();

        if ($result1) {
		  echo "<script>location.href='./members.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='./members.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');


        }
}
	  
     

      }


//   Get Single User Information By Id Method
    public function updateUserBizByUser($userid, $data){
     	$business = $data['business'];
	    $biztype = $data['biztype'];
	    $bizdesp = $data['description'];
		
		
		if(!empty($_FILES['logo']['name'])) {//new image uploaded
		  
		  //code for profile uploading
	       $logo_name = $_FILES['logo']['name'];
           $logo_size =$_FILES['logo']['size'];
           $logo_tmp =$_FILES['logo']['tmp_name'];
           $logo_type=$_FILES['logo']['type'];
		   $tmp_logo = explode('.', $logo_name);
           $logo_ext = strtolower(end($tmp_logo));
		   $logo=$logo_name;
		       // Upload directory
           $upload_logo = "../business/";
		   
		   // Get extension
           $ext = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));
		   // Valid image extension
		   $valid_ext= array("jpeg","jpg","png");
		   
		   if(in_array($ext, $valid_ext)){
			   if($logo_size < 2097152){
				   move_uploaded_file($logo_tmp,$upload_logo.$logo_name);
				   
				     $sql = "UPDATE business SET 
                     business = :business,
                     biztype = :biztype,
		             description = :description,
                     logo = :logo
                     WHERE user_id = :id";
                     $stmt= $this->db->pdo->prepare($sql);
                     $stmt->bindValue(':business', $business);
                     $stmt->bindValue(':biztype', $biztype);
		             $stmt->bindValue(':description', $bizdesp);
		             $stmt->bindValue(':logo', $logo);
                     $stmt->bindValue(':id', $userid);
                     $result = $stmt->execute();

        if ($result) {
		  echo "<script>location.href='./dashboard.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='./dashboard.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');


        }
				   
				   
				   
			   }else{
				   
			   }
		   }else{
			   
		   }
	
}else{
	$sql = "UPDATE business SET 
          business = :business,
          biztype = :biztype,
		  description = :description
          WHERE user_id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':business', $business);
          $stmt->bindValue(':biztype', $biztype);
		  $stmt->bindValue(':description', $bizdesp);
          $stmt->bindValue(':id', $userid);
          $result = $stmt->execute();

        if ($result) {
		  echo "<script>location.href='./dashboard.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='./dashboard.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');



       }
  }

   
  
	  
     

      }

//   Get Single User Information By Id Method
    public function updateUserBizImgByAdmin($userid){
		
		 if($_FILES['image']['name']){
			 
           $countfiles = count($_FILES['image']['name']);
                // Upload directory
           $files_arr = array();
              
			  if($countfiles <= 5){
				   	  // Loop all files
         for($index = 0;$index < $countfiles;$index++){

                  
                if(isset($_FILES['image']['name'][$index]) && $_FILES['image']['name'][$index] != ''){
                      // File name
                      $img_name = $_FILES['image']['name'][$index];
		              $img=$img_name;
		             // Upload directory
                       $upload_img = "../business/";
		   
		             // Get extension
                    $ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
                        // Valid image extension
                        $valid_ext = array("png","jpeg","jpg");
                                  // Check extension
                                 if(in_array($ext, $valid_ext)){
                                         // File path
                                          $path = $upload_img.$img;
                                             // Upload file
                                          if(move_uploaded_file($_FILES['image']['tmp_name'][$index],$path)){
                                                              $files_arr[] = $upload_img;
															  
											    $sql = "INSERT INTO biz_images(user_id,image) VALUES(:id, :image)";
                                                $stmt = $this->db->pdo->prepare($sql);
	                                            $stmt->bindValue(':id', $userid);
                                                $stmt->bindValue(':image', $img);
                                                $result=$stmt->execute();
	  
      
															  
                                                                   }
                                           }
                                      }
                             }
			  }else{
				  
			  }
		
   
		}

   }		 
   
//   upload image by User  By Id Method
    public function updateImgByUser($userid){
	  
	  //code for image uploading
	if($_FILES['profile']['name']){
		
	       $file_name = $_FILES['profile']['name'];
           $file_size =$_FILES['profile']['size'];
           $file_tmp =$_FILES['profile']['tmp_name'];
           $file_type=$_FILES['profile']['type'];
		   $tmp = explode('.', $file_name);
           $file_ext = strtolower(end($tmp));
		   $profile=$file_name;
         
		 
      $extensions= array("jpeg","jpg","png");
	  // check size
	   
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
	    // Check extension
          if( in_array($file_ext,$extensions) ){
     // Upload file
                if(move_uploaded_file($file_tmp,"../profile/".$file_name)){
        // Insert record
        $sql = "UPDATE tbl_users SET
          profile = :profile
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':profile', $profile);
          $stmt->bindValue(':id', $userid);
          $result =   $stmt->execute();
		  
		  if ($result) {
		  echo "<script>location.href='./dashboard.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='./dashboard.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');


        }
     }

  }
      
     
    }else{
			 echo "choose a image profile";
		 }


		 }
		 
//upload image by User  By Id Method
    public function updateBizImgByUser($userid, $data){
		
		
		if($_FILES['image']['name']){
                 // Count total files
          $countfiles = count($_FILES['image']['name']);
                // Upload directory
          $upload_location = "../business/";
               // To store uploaded files path
          $files_arr = array();
              // Loop all files
         for($index = 0;$index < $countfiles;$index++){

                if(isset($_FILES['image']['name'][$index]) && $_FILES['image']['name'][$index] != ''){
                      // File name
                      $filename = $_FILES['image']['name'][$index];
                      $image = $filename;
                         // Get extension
                      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        // Valid image extension
                        $valid_ext = array("png","jpeg","jpg");
                                  // Check extension
                                 if(in_array($ext, $valid_ext)){
                                         // File path
                                          $path = $upload_location.$filename;
                                             // Upload file
                                          if(move_uploaded_file($_FILES['image']['tmp_name'][$index],$path)){
                                                              $files_arr[] = $path;
															  
															  $sql = "INSERT INTO biz_images(user_id,image) VALUES(:id, :image)";
                                                              $stmt = $this->db->pdo->prepare($sql);
															  $stmt->bindValue(':id', $userid);
                                                              $stmt->bindValue(':image', $image);
                                                              $stmt->execute();
	  
      
															  
                                                                   }
                                           }
                                      }
                             }
   
		}


		 }	


	//Get Single User Business IMG By Id Method

 public function getBizImgById($userid){
      $sql = "SELECT * FROM business WHERE user_id = :user_id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':user_id', $userid);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);


    }	 

//Get Single User Business Info By Id Method

 public function getBizInfoById($userid){
      $sql = "SELECT * FROM business WHERE user_id = :user_id LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':user_id', $userid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
	  if ($result) {
        return $result;
      }else{
        return false;
      }
	  
    }	

//   Get Single User Information By Id Method
    public function updateUserByUser($userid, $data){
      $name = $data['name'];
      $username = $data['username'];
      $email = $data['email'];
      $mobile = $data['mobile'];


      if ($name == "" || $username == ""|| $email == "" || $mobile == ""  ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Input Fields must not be Empty !</div>';
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


      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Invalid email address !</div>';
          return $msg;
      }else{

        $sql = "UPDATE tbl_users SET
          name = :name,
          username = :username,
          email = :email,
          mobile = :mobile
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':name', $name);
          $stmt->bindValue(':username', $username);
          $stmt->bindValue(':email', $email);
          $stmt->bindValue(':mobile', $mobile);
          $stmt->bindValue(':id', $userid);
        $result =   $stmt->execute();

        if ($result) {
		  echo "<script>location.href='./dashboard.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='./dashboard.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');


        }
		
		
		
		}

      }
	  
	  
	    // Select All User Method
  public function selectAllBizImg($userid){
    $sql = "SELECT * FROM biz_images WHERE user_id = :user_id ORDER BY sl_no DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $userid);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


// Delete User  image by Admin Method
    public function deleteUserImgById($removeimg){
		          $sql = "SELECT user_id FROM biz_images WHERE sl_no = :sl_no";
                  $stmt = $this->db->pdo->prepare($sql);
				  $stmt->bindValue(':sl_no', $removeimg);
                  $stmt->execute();
                  $result1= $stmt->fetch(PDO::FETCH_OBJ);
	  
                 $sql = "DELETE FROM biz_images WHERE sl_no = :sl_no";
                 $stmt = $this->db->pdo->prepare($sql);
                 $stmt->bindValue(':sl_no', $removeimg);
	             $result =$stmt->execute();
	  
        if ($result) {
			     
			 
			echo "<script>location.href='./edit1.php?id=$result1->user_id';</script>";
          $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> User account Deleted Successfully !</div>';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Deleted !</div>';
            return $msg;
        }
    }
	
	
// Delete User  image by user Method
    public function deleteUserImgByUser($removeimg){
		          $sql = "SELECT user_id FROM biz_images WHERE sl_no = :sl_no";
                  $stmt = $this->db->pdo->prepare($sql);
				  $stmt->bindValue(':sl_no', $removeimg);
                  $stmt->execute();
                  $result1= $stmt->fetch(PDO::FETCH_OBJ);
	  
                 $sql = "DELETE FROM biz_images WHERE sl_no = :sl_no";
                 $stmt = $this->db->pdo->prepare($sql);
                 $stmt->bindValue(':sl_no', $removeimg);
	             $result =$stmt->execute();
	  
        if ($result) {
			     
			 
			echo "<script>location.href='./dashboard.php';</script>";
          $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> User account Deleted Successfully !</div>';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Deleted !</div>';
            return $msg;
        }
    }	

    // Delete User by Id Method
    public function deleteUserById($remove){
      $sql = "DELETE FROM tbl_users WHERE id = :id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $remove);
        $result =$stmt->execute();
        if ($result) {
		  echo "<script>location.href='./members.php';</script>";
          $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> User account Deleted Successfully !</div>';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Deleted !</div>';
            return $msg;
        }
    }

    // User Deactivated By Admin
    public function userDeactiveByAdmin($deactive){
      $sql = "UPDATE tbl_users SET

       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 1);
       $stmt->bindValue(':id', $deactive);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='members.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> User account Diactivated Successfully !</div>');

        }else{
          echo "<script>location.href='members.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Diactivated !</div>');

            return $msg;
        }
    }


    // User Deactivated By Admin
    public function userActiveByAdmin($active){
      $sql = "UPDATE tbl_users SET
       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 0);
       $stmt->bindValue(':id', $active);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='members.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> User account activated Successfully !</div>');
        }else{
          echo "<script>location.href='members.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not activated !</div>');
        }
    }




    // Check Old password method
    public function CheckOldPassword($userid, $old_pass){
      $old_pass = SHA1($old_pass);
      $sql = "SELECT password FROM tbl_users WHERE password = :password AND id =:id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':password', $old_pass);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        return true;
      }else{
        return false;
      }
    }



    // Change User pass By Id
    public  function changePasswordBysingelUserId($userid, $data){

      $old_pass = $data['old_password'];
      $new_pass = $data['new_password'];


      if ($old_pass == "" || $new_pass == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Password field must not be Empty !</div>';
          return $msg;
      }elseif (strlen($new_pass) < 6) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> New password must be at least 6 character !</div>';
          return $msg;
       }

         $oldPass = $this->CheckOldPassword($userid, $old_pass);
         if ($oldPass == FALSE) {
           $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong>Error !</strong> Old password did not Matched !</div>';
             return $msg;
         }else{
           $new_pass = SHA1($new_pass);
           $sql = "UPDATE tbl_users SET

            password=:password
            WHERE id = :id";

            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':password', $new_pass);
            $stmt->bindValue(':id', $userid);
            $result =   $stmt->execute();

          if ($result) {
            echo "<script>location.href='index.php';</script>";
            Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success !</strong> Great news, Password Changed successfully !</div>');

          }else{
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Error !</strong> Password did not changed !</div>';
              return $msg;
          }

         }



    }








}


