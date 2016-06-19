<?php
session_start();
require_once ("config/const.php");
require_once ("./libs/vkAuth.php");
require_once ("./config/Autoload.php");
require_once ("./Layout/header.php");
require_once ("./libs/admin_access.php");
?>

<div style="position: relative;width: 100%;margin-top: 50px">
    <div style="position: relative;width: 50%;margin: 0 auto;margin-bottom: 30px;text-align: center;">
        <p>Tournament</p>
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