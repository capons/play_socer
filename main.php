<?php
session_start();
require_once ("config/const.php");
require_once ("./libs/vkAuth.php");
require_once ("./config/Autoload.php");
//require_once ("./libs/admin_access.php");
require_once ("./Layout/header.php");
require_once ("./controllers/mainController.php")
?>

<div style="position: relative;width: 100%;margin-top: 50px">
    <div class="h-title-wraper">
        <div class="h-title-body">
            <p>User score</p>
        </div>
    </div>
    <div style="width: 100%;float: left">
        <div style="width: 100%;float: left">
            <div style="margin: 10px;float: left">


                <div class="t-head" style="">
                    <div class="t-col-one">
                        №
                    </div>
                    <div class="t-col">
                        User name
                    </div>
                    <div class="t-col">
                        Score
                    </div>
                </div>
                <?php
                if(isset($user_score)){
                    $i = 1;

                    foreach($user_score as $val) {
                        ?>
                        <div class="t-head" style="width: 100%;float: left">
                                <div class="t-col-one">
                                    <p><?php echo $i; ?></p>
                                </div>
                                <div class="t-col">
                                    <p><?php echo ucfirst($val['name']).' '.strtoupper(mb_substr($val['s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col">
                                    <p><?php echo $val['score']; ?></p>
                                </div>
                        </div>
                        <?php
                        $i++;
                    }
                }
                ?>
            </div>
        </div>
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