<?php
session_start();
require_once ("config/const.php");
require_once ("./libs/vkAuth.php");
require_once ("./config/Autoload.php");
require_once ("./Layout/header.php");
if(isset($_SESSION['user_data'])){
    $auth = new Auth();
    $auth->authAdmin($_SESSION['user_data']['id']);
} else {
    $_SESSION['user_info'] = 'You have no access';
    header('Location:'.base_path);
    die();
}
?>

<div style="position: relative;width: 100%;margin-top: 50px">
    <div style="position: relative;width: 50%;margin: 0 auto;margin-bottom: 30px;text-align: center;">
        <p>Edit Tournament</p>
    </div>
    <div style="position: relative;width: 50%;margin: 0 auto">
    </div>
</div>

<?php
$info = '';
if(isset($_SESSION['user_info'])){ ?>
    <div class="error-b" >
        <?php $info = $_SESSION['user_info'];
        unset($_SESSION['user_info']);
        echo '<p class="error-t">'.$info.'</p>'; ?>
    </div>
<?php } ?>
</body>
</html>