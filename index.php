<?php
session_start();
require_once ("config/const.php");
require_once ("./libs/vkAuth.php");
require_once ("./Layout/header.php");
?>


<div  class="auth">
     <form action="<?php base_path ?>controllers/authController.php" method="post">
         <div class="form-i">
             <div class="f-span">
                <span class="text-c">Email</span>
             </div>
             <div class="f-input">
                <input  type="email" name="email" placeholder="Email" value="admin@ram.ru" required>
             </div>
         </div>
         <div class="form-i">
             <div class="f-span">
                <span class="text-c">Password</span>
             </div>
             <div class="f-input">
                <input type="password" name="pass" placeholder="Password" required>
             </div>
         </div>

         <div class="form-i">
             <div  class="f-span">
                 <!--Sign in by VK -->
                 <?php echo $link = '<a href="' . $url . '?' . urldecode(http_build_query($params)) . '"><img id="vk" src="'.base_path.'image/vk.png" alt="альтернативный текст"></a>'; ?>
             </div>
             <div class="f-input p-cent">
                 <button id="b_look" type="submit">Sign in</button>
                 <a class="text-c" href="<?php base_path; ?>registration.php">Sign up</a>
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