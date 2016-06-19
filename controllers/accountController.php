<?php
session_start();
require_once ("../config/Autoload.php");
require_once ("../config/const.php");
if(isset($_POST['e_r_name'])) {
    $user = new User();
    $update_data = $user->update($_POST['e_user_id'],$_POST['e_r_name'],$_POST['e_r_sname'],$_POST['e_email']);
    if($update_data == true){
        $_SESSION['user_info'] = 'Successfully edited the entry';
        header('Location:'.base_path.'account.php');
        die();
    } else {
        $_SESSION['user_info'] = 'Error please try again';
        header('Location:'.base_path.'account.php');
        die();
    }

} else {
    header('Location:'.base_path);
}