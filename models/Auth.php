<?php
//require_once ("User.php");


class Auth extends User
{
    private $email='';
    private $pass='';
    public function userLogin($email,$pass){
        $this->email = parent::valid($email);
        $this->pass = parent::valid($pass);
        $auth = parent::checkLogin($this->email,md5($this->pass));
        return $auth;
    }
    public function authAdmin ($id){
        $access = parent::checkAccess($id);
        if($access['access'] != 2){
            $_SESSION['user_info'] = 'You have no access';
            header('Location:'.base_path);
            die();
        }
    }
    public function authUser ($id) {
        $access = parent::checkAccess($id);
        if($access['access'] != 2 && $access['access'] !=1){
            $_SESSION['user_info'] = 'You have no access';
            header('Location:'.base_path);
            die();
        }
    }
}