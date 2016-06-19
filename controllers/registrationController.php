<?php
session_start();
require_once ("../config/const.php");
require_once ("../config/Autoload.php");
if(isset($_POST['r_name'])) {
    $user = new User();
    $check_email = $user->checkEmail($_POST['email']);
    if($check_email === true) {
        $user_id = $user->userRegist($_POST['r_name'], $_POST['r_sname'], $_POST['email'],$_POST['r_pass']); //back last insert id
        if (!empty($user_id)) {
            if ($_FILES['upload']['size'] < 500000) {
                $check_image = array('jpg', 'gif', 'png');
                $m = $_FILES['upload']['name'];
                $type = explode(".", $m);
                $type = $type[count($type) - 1];
                if (in_array($type, $check_image)) {
                    $upload = '../upload/';
                    $t = $_FILES['upload']['tmp_name'];
                    $n = $_FILES['upload']['name'];
                    $new_image_name = substr($n, mt_rand(0, 25), 1) . substr(md5(time()), 1) . '.' . $type;
                    move_uploaded_file($t, "$upload/$new_image_name");
                    $image = $user->userImage($user_id, $new_image_name);
                    if ($image == true) {
                        $_SESSION['user_info'] = 'You have successfully registered';
                        header('Location:' . base_path);
                        exit();
                    } else {
                        $_SESSION['user_info'] = 'Please try again';
                        header('Location:' . base_path . 'registration.php');
                        exit();
                    }
                } else {
                    $_SESSION['user_info'] = 'Invalid image format';
                    header('Location:' . base_path . 'registration.php');
                    exit();
                }
            }
        }
    } else {
        $_SESSION['user_info'] = 'Email already exists';
        header('Location:' . base_path . 'registration.php');
        exit();
    }

} else {
    header('Location:' . base_path . 'registration.php');
    exit();
}

// else {
 //   $_SESSION['user_info'] = 'You have no access';
 //   header('Location:'.base_path);
 //   die();
//}

