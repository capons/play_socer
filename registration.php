<?php
session_start();
require_once ("config/const.php");
require_once ("Layout/header.php");
?>

<div  class="auth">
    <form id="r_form"  action="<?php base_path; ?>controllers/registrationController.php" method="post" enctype="multipart/form-data">
        <div class="form-i">
            <div class="f-span">
                <span class="text-c">Name</span>
            </div>
            <div class="f-input">
                <input  type="text" name="r_name" placeholder="Name" value="name" required>
            </div>
        </div>
        <div class="form-i">
            <div class="f-span">
                <span class="text-c">Surname</span>
            </div>
            <div class="f-input">
                <input  type="text" name="r_sname" placeholder="Surname" value="s_name" required>
            </div>
        </div>
        <div class="form-i">
            <div class="f-span">
                <span class="text-c">Email</span>
            </div>
            <div class="f-input">
                <input  type="email" name="email" placeholder="Email" value="bog@ram.ru" required>
            </div>
        </div>
        <div class="form-i">
            <div class="f-span">
                <span class="text-c">Password</span>
            </div>
            <div class="f-input">
                <input  type="password" name="r_pass" placeholder="Password" required>
            </div>
        </div>
        <div class="form-i">
            <div class="f-span">
                <span class="text-c im">Image</span>
            </div>
            <div class="f-input">
                <div id="btn" class="form-control" ></div>
                <input id="upfile" type="file" name="upload">
            </div>
        </div>
        

        <div class="form-i">
            <div  class="f-span">
                <!--Sign in by VK -->

            </div>
            <div class="f-input p-cent">
                <button name="r_button" id="r_look" type="submit">Sign up</button>
            </div>
        </div>

    </form>

    <?php
    $info = '';
    if(isset($_SESSION['user_info'])){ ?>
        <div class="error-b" style="width: 60%;margin: 0 auto">
            <?php $info = $_SESSION['user_info'];
            unset($_SESSION['user_info']);
            echo '<p class="error-t">'.$info.'</p>'; ?>
        </div>
    <?php } ?>


</div>
</body>
</html>