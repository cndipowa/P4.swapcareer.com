<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 */
class users_controller extends base_controller 
{
    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
      echo "You are looking at users-index";
    }
    
    public function signup()
    {
        $this->template->content=view::instance("v_users_signup");
        echo $this->template;
    }
    
    public function p_signup()
    {
        
      // Error checking: check if email already exists
	$q = "SELECT email FROM users WHERE email = '" . $_POST['email'] . "'";  
        $email = DB::instance(DB_NAME)->select_field($q);
        if ($email) {die("Email already exists! <a href='/users/signup/'>Back</a>");}
        
       // echo '<pre>'; print_r($_FILES); echo '<pre>';
        
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        
        if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 1000000))
       {  
        $_POST['created']=Time::now();
        $_POST['password']=  sha1(PASSWORD_SALT.$_POST['password']);
        $_POST['token']=  sha1(TOKEN_SALT.$_POST['email']);
        
        
        $_POST['imagepath']= "upload/" .$_POST['email'].$_FILES["file"]["name"];
            
        
        $q = 'SELECT COUNT(user_id)
             FROM users
             WHERE email = "'.$_POST['email'].'"'; 
        
        
        $result = DB::instance(DB_NAME)->select_field($q);
        
       if($result){
          $existError = "Email Already Exists";
          $this->template->content=view::instance("v_error");
          $this->template->content->existError = $existError ;
          echo $this->template; 
          
       }
       else{                
           
         DB::instance(DB_NAME)->insert_row("users",$_POST);
                  
         //Crop and Save img file
            if ($_FILES["file"]["type"] == "image/gif") {
                $image = imagecreatefromgif($_FILES["file"]["tmp_name"]);
            } 
            elseif ($_FILES["file"]["type"] == "image/jpeg") {
                $image = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
            }  
            elseif (($_FILES["file"]["type"] == "image/jpg")) {
                $image = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
            }
            elseif (($_FILES["file"]["type"] == "image/png")) {
                $image = imagecreatefrompng($_FILES["file"]["tmp_name"]);
            }

                $filename = "upload/" .$_POST['email']. $_FILES["file"]["name"] ;

                $thumb_width = 200;
                $thumb_height = 150;

                $width = imagesx($image);
                $height = imagesy($image);

                $original_aspect = $width / $height;
                $thumb_aspect = $thumb_width / $thumb_height;

                if ( $original_aspect >= $thumb_aspect )
                {
                   // If image is wider than thumbnail (in aspect ratio sense)
                   $new_height = $thumb_height;
                   $new_width = $width / ($height / $thumb_height);
                }
                else
                {
                   // If the thumbnail is wider than the image
                   $new_width = $thumb_width;
                   $new_height = $height / ($width / $thumb_width);
                }

                $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

                // Resize and crop
                imagecopyresampled($thumb,
                                   $image,
                                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                                   0, 0,
                                   $new_width, $new_height,
                                   $width, $height);
                imagejpeg($thumb, $filename, 80);
               
                
         $success = "Successfully added ! Now login please.";
         $this->template->content=view::instance("v_users_login");
         $this->template->content->success=$success;
         echo $this->template;
       }
     }
     else
     {die("Invalid File ! <a href='/users/signup/'>Back</a>");} 
   }
    
    
    
    
    public function login()
    {
        $this->template->content=view::instance("v_users_login");
        echo $this->template;
    }
    public function p_login()
    {
        $_POST['password']=  sha1(PASSWORD_SALT.$_POST['password']);
        
        $q = 'SELECT token 
             FROM users
             WHERE email = "'.$_POST['email'].'"
             AND password = "'.$_POST['password'].'"';
        
        $token = DB::instance(DB_NAME)->select_field($q);
        
        if($token)
        {
            
            setcookie('token', $token, strtotime('+1 year'),'/' );
            Router::redirect('/');
        }
        else 
        {
            $loginError = "Not Found!";
           // Router::redirect('/')    
            $this->template->content=view::instance("v_index_index");
            $this->template->content->loginError = $loginError;
            echo $this->template;
        }
        
    }
    
    public function logout()
    {
        
            
       $new_token =  sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
       $data = Array('token'=>$new_token);
        
       
       DB::instance(DB_NAME)->update('users' ,$data, 'WHERE user_id ='. $this->user->user_id);
       setcookie('token','',  strtotime('-1 year'),'/');
       Router::redirect('/');
       

    }
    
    public function profile() {
    
    	# If user is blank, redirect them to the login page
    	if(!$this->user) {
    		
    		Router::redirect('/users/login');
       	}
    	

    	$this->template->content = View::instance('v_users_profile');
    	$this->template->title = "Profile of ".$this->user->firstname;
  
  		
  		$avatar = $this->user->avatar;
  		
  		# Pass data to the view
  		$this->template->content->avatar = $avatar;    	     	
    	
    	# Render template
    	echo $this->template;
    }
    
    public function edit_profile() {
    
    	# If user is blank, redirect them to the login page
    	if(!$this->user) {
    		
    		Router::redirect('/users/login');
       	}
    
    	# Setup the view
    	$this->template->content = View::instance('v_users_edit_profile');
    	$this->template->title = "Edit profile of ".$this->user->firstname;
    	
    	$avatar = $this->user->avatar;
    	
    	# Pass data to the view
    	$this->template->content->avatar = $avatar; 
    	    	
    	# Select user's data from the database
 		$q = "SELECT *
 			FROM users 
 			WHERE user_id = ".$this->user->user_id;
 					
 		$this_user = DB::instance(DB_NAME)->select_row($q);
 		
 		# Create new form object and pass form data to the view
 		$this->template->content->form = New Form($this_user);
    	
    	# Render template    	
    	echo $this->template;
    }
    
    public function p_edit_profile() { 
    
    	# Prevent special characters
    	$_POST['bio'] = htmlentities($_POST['bio']);
    
    	# Update users bio information
		$data = Array("bio" => $_POST['bio']);
	   
		DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = ".$this->user->user_id);
	   
		# Redirect to profile page
		Router::redirect("/users/profile");
    
    }
    
    public function upload_avatar() {
    
    	# If user is blank, redirect to the login page
    	if(!$this->user) {
    		
    		Router::redirect('/users/login');
    	}
    
    	# Setup the view
    	$this->template->content = View::instance('v_users_upload_avatar');
    	$this->template->title = "Upload avatar of ".$this->user->firstname;
    	
    	$avatar = $this->user->avatar;
    	
    	# Pass data to the view
    	$this->template->content->avatar = $avatar;
    	
    	# Render template
    	echo $this->template;
    
    }
    
    public function p_upload_avatar() {
   
   		if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
	    	
	    	# Upload avatar picture
	    	$avatar = Upload::upload($_FILES, "/upload/", array("jpg", "jpeg", "gif", "png"), $this->user->user_id);
	    	
	    	
	    	$extentions = array("image/jpg", "image/jpeg", "image/gif", "image/png");
	    	if (!in_array($_FILES['avatar']['type'], $extentions)) {
	    		echo "Error! .jpg, .jpeg, .png, .gif images only. Please <a href='/users/upload_avatar/'>try again.</a>";
	    	}
	    	
	    	else {
	   
               //$filename = "upload/" .$this->user->user_id ;
                     
	       	# Update database
	       	$data = Array("imagepath" => "upload/".$avatar);
	    	
	    	DB::instance(DB_NAME)->update("users", $data, "WHERE  user_id = ".$this->user->user_id);
	    	
	    	# Create new image object and resize it
	    	$imgObj = new Image(APP_PATH."upload/" .$avatar);
	    	
	    	$imgObj->resize(150,150, "crop");
	    	
	    	$imgObj->save_image(APP_PATH."upload/" .$avatar );
	    	
	    	# Render template
	    	Router::redirect("/users/profile"); 
	    	}
    	} 
    	
    	else {
    		echo "Error! You haven't chosen any image. Please <a href='/users/upload_avatar/'>try again.</a>";
    	}
      }
  }

