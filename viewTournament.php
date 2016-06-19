<?php
session_start();
require_once ("config/const.php");
require_once ("./libs/vkAuth.php");
require_once ("./config/Autoload.php");
require_once ("./Layout/header.php");
require_once ("./controllers/viewTournamentController.php");
if(isset($_SESSION['user_data'])){
    $auth = new Auth();
    $auth->authAdmin($_SESSION['user_data']['id']);
} else {
    $_SESSION['user_info'] = 'You have no access';
    header('Location:'.base_path);
    die();
}
?>
<?php
if(!isset($_GET['t_if'])) {

    ?>
    <div class="h-title-wraper">
        <div class="h-title-body">
            <p>Tournament list</p>
        </div>
    </div>
    <div style="width: 100%;float: left">
        <div style="width: 100%;float: left">
            <div style="margin: 10px;float: left">

            <div class="t-head">
                <div class="t-col" >
                    №
                </div>
                <div class="t-col">
                    Tournament name
                </div>
                <div class="t-col">
                    Tournament type
                </div>
                <div class="t-col">
                    Tournament status
                </div>
            </div>
            <?php
            $tournament = new Tournament();
            $all_tournament = $tournament->tournamentView();
            $i = 1;
            while ($row = $all_tournament->fetch_assoc()) {


                ?>
                <div class="t-head" style="width: 100%;float: left">
                    <div class="t-col" style="width: 20%;float: left;padding: 10px">
                        <p><?php echo $i; ?></p>
                    </div>
                    <div class="t-col" style="width: 20%;float: left;padding: 10px">
                        <a class="tour-link"
                           href="<?php echo base_path; ?>viewTournament.php?t_if=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
                    </div>
                    <div class="t-col" style="width: 20%;float: left;padding: 10px">
                        <p><?php echo $row['type']; ?></p>
                    </div>
                    <div class="t-col" style="width: 20%;float: left;padding: 10px">
                        <p><?php echo $row['status']; ?></p>
                    </div>
                </div>
                <?php
                $i++;
            }
            ?>
                </div>
        </div>
    </div>
    <?php
} elseif(isset($tournament_result)) {
    ?>
    <div class="h-title-wraper">
        <div class="h-title-body">
            <p>Tournament details</p>
        </div>
    </div>
    <div style="width: 100%;float: left">
        <div style="width: 100%;float: left">
            <div style="margin: 10px;float: left">


            <div class="t-head" style="width: 100%;float: left">
                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                    №
                </div>
                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                    Team a
                </div>
                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                    Team b
                </div>
                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                    Result
                </div>
            </div>
            <?php
            if(isset($tournament_result)){
            $i = 1;

                foreach($tournament_result as $val) {
                    ?>
                    <div class="t-head" style="width: 100%;float: left">
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            <p><?php echo $i; ?></p>
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            <p><?php echo ucfirst($val['name']).' '.strtoupper(mb_substr($val['s_name'],0,1)).'.'; ?></p>
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            <p><?php echo ucfirst($val['b_name']).' '.strtoupper(mb_substr($val['b_s_name'],0,1)).'.'; ?></p>
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
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
    <?php
} elseif(isset($first_match) && isset($second_match) && isset($third_match) && isset($final_match)) {
    ?>
    <div class="border-bb">


        <div class="h-title-wraper">
            <div class="h-title-body">
                <p>Playoff 1/8</p>
            </div>
        </div>
        <div style="width: 100%;float: left">
            <div style="width: 100%;float: left">
                <div style="margin: 10px;float: left">


                    <div class="t-head" style="width: 100%;float: left">
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            №
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Team a
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Team b
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Result
                        </div>
                    </div>
                    <?php
                    if(isset($first_match)){
                        $i = 1;

                        foreach($first_match as $val) {
                            ?>
                            <div class="t-head" style="width: 100%;float: left">
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo $i; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo ucfirst($val['name']).' '.strtoupper(mb_substr($val['s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo ucfirst($val['b_name']).' '.strtoupper(mb_substr($val['b_s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo $val['result']; ?></p>
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
    </div>

    <div class="border-bb">
        <div class="h-title-wraper">
            <div class="h-title-body">
                <p>Playoff 1/4</p>
            </div>
        </div>
        <div style="width: 100%;float: left">
            <div style="width: 100%;float: left">
                <div style="margin: 10px;float: left">


                    <div class="t-head" style="width: 100%;float: left">
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            №
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Team a
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Team b
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Result
                        </div>
                    </div>
                    <?php
                    if(isset($second_match)){
                        $i = 1;

                        foreach($second_match as $val) {
                            ?>
                            <div class="t-head" style="width: 100%;float: left">
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo $i; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo ucfirst($val['name']).' '.strtoupper(mb_substr($val['s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo ucfirst($val['b_name']).' '.strtoupper(mb_substr($val['b_s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo $val['result']; ?></p>
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
    </div>


    <div class="border-bb">
        <div class="h-title-wraper">
            <div class="h-title-body">
                <p>Playoff 1/2</p>
            </div>
        </div>
        <div style="width: 100%;float: left">
            <div style="width: 100%;float: left">
                <div style="margin: 10px;float: left">


                    <div class="t-head" style="width: 100%;float: left">
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            №
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Team a
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Team b
                        </div>
                        <div class="t-col" style="width: 20%;float: left;padding: 10px">
                            Result
                        </div>
                    </div>
                    <?php
                    if(isset($third_match)){
                        $i = 1;

                        foreach($third_match as $val) {
                            ?>
                            <div class="t-head" style="width: 100%;float: left">
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo $i; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo ucfirst($val['name']).' '.strtoupper(mb_substr($val['s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo ucfirst($val['b_name']).' '.strtoupper(mb_substr($val['b_s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col" style="width: 20%;float: left;padding: 10px">
                                    <p><?php echo $val['result']; ?></p>
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
    </div>

    <div class="border-bb">
        <div class="h-title-wraper">
            <div class="h-title-body">
                <p>Playoff final match</p>
            </div>
        </div>
        <div style="width: 100%;float: left">
            <div style="width: 100%;float: left">
                <div style="margin: 10px;float: left">


                    <div class="t-head">
                        <div class="t-col">
                            №
                        </div>
                        <div class="t-col">
                            Team a
                        </div>
                        <div class="t-col">
                            Team b
                        </div>
                        <div class="t-col">
                            Result
                        </div>
                    </div>
                    <?php
                    if(isset($final_match)){
                        $i = 1;

                        foreach($final_match as $val) {
                            ?>
                            <div class="t-head">
                                <div class="t-col" >
                                    <p><?php echo $i; ?></p>
                                </div>
                                <div class="t-col" >
                                    <p><?php echo ucfirst($val['name']).' '.strtoupper(mb_substr($val['s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col">
                                    <p><?php echo ucfirst($val['b_name']).' '.strtoupper(mb_substr($val['b_s_name'],0,1)).'.'; ?></p>
                                </div>
                                <div class="t-col" >
                                    <p><?php echo $val['result']; ?></p>
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
    </div>
    <?php
}
?>
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