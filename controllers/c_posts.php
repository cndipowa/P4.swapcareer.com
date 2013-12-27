<?php

class posts_controller extends base_controller 
{   
    public function __construct() {
    parent::__construct();
    
    if(!$this->user){
    die("Access to the part of the site is restricted to members only ! <a href='/index/index/'>Please click here to go back</a>");
    }
  
    }
    
    public function index()
    {
      $this->template->content = View::instance('v_posts_index');
      $q = 'SELECT 
                posts.content,
                posts.created,
                posts.user_id AS post_user_id,
                users_users.user_id AS follower_id,
                users.firstname,
                users.lastname,
                users.imagepath
            FROM posts
            INNER JOIN users_users 
                ON posts.user_id = users_users.user_id_followed
            INNER JOIN users 
                ON posts.user_id = users.user_id
            WHERE users_users.user_id = '.$this->user->user_id;
      try{
      $posts = DB::instance(DB_NAME)->select_rows($q);
       }
        catch(Exception $e){echo 'There has been an error processing your request. Please contact the website administrator.';echo $e->getMessage();
       }
      $this->template->content->posts=$posts;
      echo $this->template;
      
     }
      
       
    public function add()
    {
        $this->template->content=View::instance('v_posts_add');
        echo $this->template;
                
    }
    public function p_add()
    {
        $_POST['user_id']  =  $this->user->user_id;
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();
        
        
        try{        
            DB::instance(DB_NAME)->insert('posts', $_POST); 
            $successMsg = "Post Added Successfully. You are also only allowed to see the posts of people you are following. ";
            
        }
        catch(Exception $e)
        {$successMsg = 'There has been an error processing your request. Please contact the website administrator.';echo $e->getMessage();
     
        }
       // Router::redirect('/posts/index');
        $this->template->content=View::instance('v_posts_index');
        $this->template->content->successMsg = $successMsg;
             
        echo $this->template;
       
    }
    
       public function users()
    {
        $this->template->content=View::instance('v_posts_users');
        
        $q ='SELECT * FROM users';
        
        $users = DB::instance(DB_NAME)->select_rows($q);
        
        $q ='SELECT * FROM users_users WHERE user_id = '.$this->user->user_id;
      try{
        $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
         }
        catch(Exception $e){echo 'There has been an error processing your request. Please contact the website administrator.';echo $e->getMessage();
}
               
        $this->template->content->users = $users;
        $this->template->content->connections = $connections;
        
        echo $this->template;
                
    } 
    
    public function follow($user_id_followed)
    {
        //prepare the data array to be inserted
          
          $data = Array(
              'created'=>Time::now(),
              'user_id'=>  $this->user->user_id,
              'user_id_followed'=>$user_id_followed
          );
          //do the insert
          try{
          DB::instance(DB_NAME)->insert('users_users',$data);
           }
        catch(Exception $e){echo 'There has been an error processing your request. Please contact the website administrator.';echo $e->getMessage();
}
          //send them back
          
          Router::redirect('/posts/users');
    }
    
    public function unfollow($user_id_followed)
    {
       // delete this connection
          $where_condition= 'WHERE user_id = '.$this->user->user_id. ' AND user_id_followed =  '.$user_id_followed;
          try{
          DB::instance(DB_NAME)->delete('users_users', $where_condition);
           }
        catch(Exception $e){echo 'There has been an error processing your request. Please contact the website administrator.';echo $e->getMessage();
}
          //send them back
          
          Router::redirect('/posts/users');
                
    }
}