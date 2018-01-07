<?php

class UserController extends BaseController{
    
    public static function login(){
        View::make('user/login.html', array('message' => 'Welcome, sign in!'));
    }
    
    public static function handle_login(){
        $params = $_POST;
        
        $user = User::authenticate($params['username'], $params['password']);
        
        if(!$user){
            View::make('user/login.html', array(
                'error' => 'Wrong username or password.', 
                'username' => $params['username']));
        }else{
            $_SESSION['user'] = $user->id;
            Redirect::to('/task', array('message' => 'Welcome back ' . $user->username . '!'));
        }
    }
    
    public static function handle_logout(){
        $_SESSION['user'] = NULL;
        Redirect::to('/login', array('message' => 'Goodbye!'));              
    }
    
}
