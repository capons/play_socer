<?php
if(isset($_SESSION['user_data'])){
    $auth = new Auth();
    $auth->authAdmin($_SESSION['user_data']['id']);
} else {
    $_SESSION['user_info'] = 'You have no access';
    header('Location:'.base_path);
    die();
}