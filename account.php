<?php
session_start();
require_once ("config/const.php");
require_once ("./libs/vkAuth.php");
require_once ("./config/Autoload.php");
require_once ("./Layout/header.php");
if(isset($_SESSION['user_data'])){
    $auth = new Auth();
    $auth->authUser($_SESSION['user_data']['id']);
} else {
    $_SESSION['user_info'] = 'You have no access';
    header('Location:'.base_path);
    die();
}
?>
<div style="position: relative;width: 100%;margin-top: 50px">
    <div style="position: relative;width: 50%;margin: 0 auto;margin-bottom: 30px;text-align: center;">
        <p>Edit user data</p>
    </div>
    <div style="position: relative;width: 50%;margin: 0 auto">
        <?php
        $user = new User();
        $u_data = $user->selectUser($_SESSION['user_data']['id']);
        ?>
            <form id="ed_form"  action="<?php base_path; ?>controllers/accountController.php" method="post">
                <input type="hidden" name="e_user_id" value="<?php echo $u_data['id']; ?>">
                <div class="form-i">
                    <div class="f-span">
                        <span class="text-c">Edit name</span>
                    </div>
                    <div class="f-input">
                        <input  type="text" name="e_r_name"  value="<?php echo $u_data['name']; ?>" required>
                    </div>
                </div>
                <div class="form-i">
                    <div class="f-span">
                        <span class="text-c">Edit surname</span>
                    </div>
                    <div class="f-input">
                        <input  type="text" name="e_r_sname"  value="<?php echo $u_data['s_name']; ?>" required>
                    </div>
                </div>
                <div class="form-i">
                    <div class="f-span">
                        <span class="text-c">Edit email</span>
                    </div>
                    <div class="f-input">
                        <input  type="email" name="e_email" value="<?php echo $u_data['email']; ?>" required>
                    </div>
                </div>



                <div class="form-i">
                    <div  class="f-span">
                        <!--Sign in by VK -->

                    </div>
                    <div class="f-input p-cent">
                        <button name="r_button" id="r_look" type="submit">Edit</button>
                    </div>
                </div>

            </form>
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