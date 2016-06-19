<?php
session_start();
require_once ("../config/Autoload.php");
require_once ("../config/const.php");
if(isset($_POST['tour_type'])) {
    $tournament = new Tournament();
    $add_rournament = $tournament->tournamentRegist($_POST['tour_type'],$_POST['tour_name']);
    if($add_rournament == true){
        $_SESSION['user_info'] = 'Successfully add tournament';
        header('Location:'.base_path.'creatTournament.php');
        die();
    } else {
        $_SESSION['user_info'] = 'Error please try again';
        header('Location:'.base_path.'creatTournament.php');
        die();
    }
} elseif(isset($_POST['team_name'])){
    $team = new Team();
    $add_team = $team->teamRegist($_POST['team_name'],$_POST['team_country']);
    if($add_team == true){
        $_SESSION['user_info'] = 'Successfully add team';
        header('Location:'.base_path.'creatTournament.php');
        die();
    } else {
        $_SESSION['user_info'] = 'Error please try again';
        header('Location:'.base_path.'creatTournament.php');
        die();
    }


} elseif(isset($_POST['tour_type_j'])){
    if(count($_POST) < 17){
        $_SESSION['user_info'] = 'You need to choose 16 teams for the tournament';
        header('Location:'.base_path.'creatTournament.php');
        die();
    }elseif(count($_POST) > 17){
        $_SESSION['user_info'] = 'You need to choose 16 teams for the tournament';
        header('Location:'.base_path.'creatTournament.php');
        die();
    } else {



        $tournament_id = $_POST['tour_type_j'];
        unset($_POST['tour_type_j']);
        $tournament = new Tournament();
        $tournament_is_full = $tournament->tournamentFull($tournament_id);
        if($tournament_is_full == false) {
            $play = new Play();
            $check_tournament = $play->checkTournamentTeam($tournament_id);
            if ($check_tournament == true) {
                $team_id = array(); // push all team id to check -> if team in tournament or no
                foreach ($_POST as $val) {
                    $team_id[] = '(' . $val . ',' . '1' . ')';
                }
                $sql_data = implode(',', $team_id); //array to check if team in tournament or no
                $user = new User();
                $update_team_play_status = $user->teamTournament($sql_data);
                if ($update_team_play_status == true) {
                    $add_team_tournament = $play->teamRegist($_POST, $tournament_id);
                    if ($add_team_tournament == true) {
                        $tournament_full = $tournament->tournamentTeamStatus($tournament_id);
                        if ($tournament_full == true) {
                            $_SESSION['user_info'] = 'Successfully add teams in the tournament';
                            header('Location:' . base_path . 'creatTournament.php');
                            die();
                        } else {
                            $_SESSION['user_info'] = 'Error please try again';
                            header('Location:' . base_path . 'creatTournament.php');
                            die();
                        }


                    } else {
                        $_SESSION['user_info'] = 'Error please try again';
                        header('Location:' . base_path . 'creatTournament.php');
                        die();
                    }
                } else {
                    $_SESSION['user_info'] = 'Error please try again';
                    header('Location:' . base_path . 'creatTournament.php');
                    die();
                }
            } else {
                $_SESSION['user_info'] = 'The tournament is already filled';
                header('Location:' . base_path . 'creatTournament.php');
                die();
            }
        } else {
            $_SESSION['user_info'] = 'The tournament is already full';
            header('Location:' . base_path . 'creatTournament.php');
            die();
        }
    }
}elseif(isset($_POST['check-b-b'])){
    $tournament_id = $_POST['check-b-b'];
    $tournament = new Tournament();
    $check_tournament = $tournament->checkTournametn($tournament_id);



    if($check_tournament['status'] == 'not started') {
        $play = new Play();
        $all_team = $play->selectTournamentTeam($tournament_id);
        $team_id = array();
        $team_to_play = array();
        if ($all_team !== false) {
            $s_x = 1;
            while ($row = $all_team->fetch_assoc()) {
                $team_id[] = $row['team_id'];
                $team_to_play[] = 'p' . $s_x++ . '=' . (int)$row['team_id'];
            }
            $add_play_team = $play->addPlayTeam($tournament_id, $team_id, $team_to_play);
            if (!in_array(false, $add_play_team)) {
                $update_tournament_status = $tournament->updateTournament($tournament_id, 'running');
                if ($update_tournament_status == true) {
                    $all_tournament_play_team = $play->selectAllPLayTeam($tournament_id);
                    if($all_tournament_play_team !== false) {
                        $order_play = $play->orderPlay($all_tournament_play_team);
                        if($order_play !== false){


                            //ПЕРЕНЕСТИ "end" в самый конец условий
                           // $end_tournament_status = $tournament->updateTournament($tournament_id,'end');
                            //if($end_tournament_status == true) {


                                $tournament_team = $play->tournamentTeam($tournament_id);
                                if($tournament_team == true){ //free team status -> team can play again
                                    $t_team = array();
                                    while ($row = $tournament_team->fetch_assoc()){
                                        $t_team[] = '(' . $row['team_id'] . ',' . '0' . ')';
                                    }
                                    $sql_data = implode(',', $t_team);
                                    $user = new User();
                                    $free_team = $user->teamTournament($sql_data);
                                    if($free_team == true) {

                                        $team_score = $play->playScore($tournament_id);



                                        if($team_score == true){


                                            $up_team_id = array();
                                            $up_team_score = array();
                                            while ($row = $team_score->fetch_assoc()){
                                                $up_team_id[] = $row['winner'];
                                                $up_team_score[] = 3*$row['win_number'];
                                            }
                                            $sql_in_id = implode(',',$up_team_id);
                                            $team_update_data = $user->selectUpTeam($sql_in_id);
                                            if($team_update_data == true){
                                                $team_old_score = array();
                                                while ($row = $team_update_data->fetch_assoc()){
                                                    $team_old_score[] = $row['score'];
                                                }

                                                $team_update_score = array();
                                                $x = 0;
                                                $j = 0;
                                                $k = 0;
                                                foreach($up_team_id as $val){ //convert update data
                                                    $team_update_score[] = '('.$up_team_id[$x].','.($team_old_score[$j]+$up_team_score[$k]).')';
                                                    $x++;
                                                    $j++;
                                                    $k++;
                                                }
                                                $sql_up_score = implode(',',$team_update_score);
                                                $score = $user->teamScore($sql_up_score); //update user score data
                                                if($score == true){
                                                    $end_tournament_status = $tournament->updateTournament($tournament_id,'end');
                                                    if($end_tournament_status == true) {
                                                        $_SESSION['user_info'] = 'The tournament is over! LOOK AT THE RESULTS!';
                                                        header('Location:' . base_path . 'creatTournament.php');
                                                        die();
                                                    } else {
                                                        $_SESSION['user_info'] = 'Error please try again!';
                                                        header('Location:' . base_path . 'creatTournament.php');
                                                        die();
                                                    }


                                                } else {
                                                    $_SESSION['user_info'] = 'Error please try again!';
                                                    header('Location:' . base_path . 'creatTournament.php');
                                                    die();
                                                }

                                            }


                                        }else {
                                            $_SESSION['user_info'] = 'Error please try again!';
                                            header('Location:' . base_path . 'creatTournament.php');
                                            die();
                                        }
                                    } else {
                                        $_SESSION['user_info'] = 'Error please try again!';
                                        header('Location:' . base_path . 'creatTournament.php');
                                        die();
                                    }
                                } else {
                                    $_SESSION['user_info'] = 'Error please try again!';
                                    header('Location:' . base_path . 'creatTournament.php');
                                    die();
                                }
                            /*
                            } else {
                                $_SESSION['user_info'] = 'Error please try again!';
                                header('Location:' . base_path . 'creatTournament.php');
                                die();
                            }
                            */
                        }else {
                            $_SESSION['user_info'] = 'Error please try again!';
                            header('Location:' . base_path . 'creatTournament.php');
                            die();
                        }
                    }
                    die();

                } else {
                    $_SESSION['user_info'] = 'Error please try again!';
                    header('Location:' . base_path . 'creatTournament.php');
                    die();
                }
            } else {
                $_SESSION['user_info'] = 'Error please try again!';
                header('Location:' . base_path . 'creatTournament.php');
                die();
            }
        } else {
            $_SESSION['user_info'] = 'Add team to the tournament!';
            header('Location:' . base_path . 'creatTournament.php');
            die();
        }
    }elseif($check_tournament['status'] == 'end'){
        $_SESSION['user_info'] = 'The tournament ended!';
        header('Location:' . base_path . 'creatTournament.php');
        die();
    } else {
        $_SESSION['user_info'] = 'The tournament has started!';
        header('Location:' . base_path . 'creatTournament.php');
        die();
    }
} else {
    $_SESSION['user_info'] = 'You have no access!';
    header('Location:'.base_path.'creatTournament.php');
    die();
}