<?php
session_start();
require_once ("../config/const.php");
if(isset($_POST['log_out'])){
    unset($_SESSION['user_data']);
    $_SESSION['user_info'] = 'You have successfully log out';
    header('Location:'.base_path);
    die();
} else {
    header('Location:'.base_path);
    die();
}