<?php
session_start();
require_once ("../config/Autoload.php");
require_once ("../config/const.php");
if(isset($_POST['email']) && (isset($_POST['pass']))) {
    $auth = new Auth();
    $sign_in = $auth->userLogin($_POST['email'],$_POST['pass']);
    if($sign_in !== false){
        $_SESSION['user_data'] = $sign_in;
        $_SESSION['user_info'] = 'You have successfully sign in';
        header('Location:'.base_path.'account.php');
        die();
    } else {
        $_SESSION['user_info'] = 'Wrong email or password';
        header('Location:'.base_path);
        die();
    }
} else {
    header('Location:'.base_path);
}


