<?php
session_start();
require_once ("config/const.php");
require_once ("./libs/vkAuth.php");
require_once ("./config/Autoload.php");
require_once ("./Layout/header.php");
require_once ("./libs/admin_access.php");

?>

<div class="c-full-w b-top">

    <div style="position: relative;width: 50%;display: inline-block;">
        <div class="c-t-full-w">
            <div class="c-t-head">
                <p>Creat Tournament</p>
            </div>
        </div>
        <div class="c-t-full-w">
            <div>
                <form action="<?php base_path ?>controllers/creatTournamentController.php" method="post">
                    <div class="form-full">
                        <div class="f-span-f">
                            <span class="text-c">Tournament type</span>
                        </div>
                        <div class="f-input-f">
                            <select name="tour_type" style="width: 145px;" required>
                                <option></option>
                                <?php
                                $round = new Round();
                                $tournament_round = $round->selectRound();
                                if(!empty($tournament_round)) {
                                    while ($row = $tournament_round->fetch_assoc()) {
                                        echo $row['type'];

                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-full">
                        <div class="f-span-f">
                            <span class="text-c">Tournament name</span>
                        </div>
                        <div class="f-input-f">
                            <input type="text" name="tour_name" placeholder="Name" required>
                        </div>
                    </div>

                    <div class="form-full">
                        <div  class="f-span">

                        </div>
                        <div style="text-align: center" class="f-input p-cent">
                            <button id="b_look-t" type="submit">Add</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div  class="c-full-w b-top">


</div>







<div style="width: 100%;float: left">

    <div style="float:left;width: 50%;min-height: 500px;">
        <div  style="padding: 5px">
        <?php
        $tournament = new Tournament();
        $check_tournament = $tournament->selectTournametnTable();
        if($check_tournament !==false) {
            ?>

            <div class="c-t-head-t">
                <p>Add participants to the tournament (Tournament table)</p>
            </div>
            <form action="<?php base_path ?>controllers/creatTournamentController.php" method="post">
                <div class="form-full">
                    <div style="text-align: center" class="f-span-top">
                        <span class="text-c">Teams to participate in the tournament (need to be 16)</span>
                    </div>

                    <?php
                    $team = new User();
                    $all_team = $team->selectAllUser();
                    while ($row = $all_team->fetch_assoc()) {
                        ?>
                        <div class="t-c-b">
                            <input type="checkbox" checked name="check-b-<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" placeholder="Name"><span style="margin-left: 3px"><?php echo ucfirst($row['name']).' '.strtoupper(mb_substr($row['s_name'],0,1)).'.'; ?></span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="form-full">
                    <div class="f-span-top">
                        <span class="text-c">Select tournament</span>
                    </div>
                    <div class="f-input-f">
                        <select name="tour_type_j" style="width: 145px;" required>
                            <option></option>
                            <?php
                            $tournament = new Tournament();
                            $tournament_all = $tournament->selectTournametnTable();
                            if (!empty($tournament_all)) {
                                while ($row = $tournament_all->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-full">

                    <div style="text-align: left; margin-top: 10px" class="f-input p-cent">
                        <button id="b_look" type="submit">Add</button>
                    </div>
                </div>

            </form>


            <div  class="c-full-w">
                <div class="half-center">
                    <form action="<?php base_path ?>controllers/creatTournamentController.php" method="post">
                        <div class="form-full">
                            <div class="f-span-top">
                                <span class="text-c">Choose a tournament and start the game</span>
                            </div>

                            <?php
                            $tournament_all_p = $tournament->selectTournametnTable();
                            if (!empty($tournament_all_p)) {
                                while ($row = $tournament_all_p->fetch_assoc()) {
                                    ?>
                                    <div class="t-c-b-b">
                                        <input type="checkbox" checked name="check-b-b" value="<?php echo $row['id']; ?>" placeholder="Name"><span style="margin-left: 3px"><?php echo ucfirst($row['name']); ?></span>
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="form-full">
                            <div style="text-align: center; margin-top: 10px;width: 100%" class="f-input p-cent">
                                <button  id="b_look_t" type="submit">Play tournament</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        } else {
            echo '<p style="text-align: center">'.'No available tournaments'.'</p>';
        }

        ?>
        </div>

    </div>

    <div style="float:right;width: 50%;min-height: 500px;">
        <div class="l-border" style="padding: 5px;min-height: 490px">
        <?php
        $tournament = new Tournament();
        $check_tournament = $tournament->selectTournametnPlayoff();
        if(!empty($check_tournament)) {
            ?>

            <div class="c-t-head-t">
                <p>Add participants to the tournament (PLayoff)</p>
            </div>
            <form action="<?php base_path ?>controllers/playoffController.php" method="post">
                <div class="form-full">
                    <div style="text-align: center" class="f-span-top">
                        <span class="text-c">Teams to participate in the tournament (need to be 8)</span>
                    </div>

                    <?php
                    //$team = new Team();
                    $team = new User();
                    $all_team = $team->selectAllUser();
                    while ($row = $all_team->fetch_assoc()) {
                        ?>
                        <div class="t-c-b">
                            <input type="checkbox" checked name="check-b-playoff-<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" placeholder="Name"><span style="margin-left: 3px"><?php echo $row['name'] ?></span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div  class="form-full">
                    <div class="f-span-top">
                        <span class="text-c">Select tournament</span>
                    </div>
                    <div class="f-input-f">
                        <select name="tour_type_playoff" style="width: 145px;" required>
                            <option></option>
                            <?php
                            $tournament = new Tournament();
                            $tournament_all = $tournament->selectTournametnPlayoff();

                            if (!empty($tournament_all)) {
                                while ($row = $tournament_all->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-full">

                    <div style="text-align: left; margin-top: 10px" class="f-input p-cent">
                        <button id="b_look-t-p" type="submit">Add</button>
                    </div>
                </div>

            </form>


            <div  class="c-full-w">
                <div class="half-center">
                    <form action="<?php base_path ?>controllers/playoffController.php" method="post">
                        <div class="form-full">
                            <div class="f-span-top">
                                <span class="text-c">Choose a tournament and start the game</span>
                            </div>

                            <?php
                            $tournament_all_p = $tournament->selectTournametnPlayoff();
                            //print_r($tournament_all_p);
                            //die();
                            if (!empty($tournament_all_p)) {
                                while ($row = $tournament_all_p->fetch_assoc()) {
                                    ?>
                                    <div class="t-c-b-b">
                                        <input type="radio" name="check-b-b-playoff" value="<?php echo $row['id']; ?>" required placeholder="Name"><span style="margin-left: 3px"><?php echo $row['name'] ?></span>
                                    </div>

                                    <?php
                                }
                            } else {
                                echo 'No Playoff tournament';
                            }
                            ?>
                        </div>
                        <div class="form-full">
                            <div style="text-align: center; margin-top: 10px;width: 100%" class="f-input p-cent">
                                <button  id="b_look_t-t-t" type="submit">Play tournament</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        } else {
            echo '<p style="text-align: center">'.'No available tournaments'.'</p>';
        }

        ?>
        </div>

    </div>
    <div class="t-border" style="width: 100%;float: left;height: 2px">

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