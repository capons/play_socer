<?php
session_start();
require_once ("../config/Autoload.php");
require_once ("../config/const.php");

if(isset($_POST['tour_type_playoff'])){
    if(count($_POST) < 17){
        $_SESSION['user_info'] = 'You need to choose 16 teams for the tournament';
        header('Location:'.base_path.'creatTournament.php');
        die();
    } elseif(count($_POST) > 17){
        $_SESSION['user_info'] = 'You need to choose 16 teams for the tournament';
        header('Location:'.base_path.'creatTournament.php');
        die();
    } else {
        $tournament_id = $_POST['tour_type_playoff'];
        //unset($_POST['tour_type_playoff']);
        $tournament = new Tournament();
        $tournament_is_full = $tournament->tournamentFull($tournament_id);
        if($tournament_is_full == false) {
            $play = new Playoff();
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

                    $add_team_tournament = $play->teamRegist($_POST);

                    if (!empty($add_team_tournament)) {
                        //$play_off_id = $add_team_tournament;
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

                    }else {
                        $_SESSION['user_info'] = 'Error please try again';
                        header('Location:' . base_path . 'creatTournament.php');
                        die();
                    }
                }else {
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
}elseif(isset($_POST['check-b-b-playoff'])){
    $tournament_id = $_POST['check-b-b-playoff'];
    $tournament = new Tournament();
    $check_tournament = $tournament->checkTournametn($tournament_id);
    if($check_tournament['status'] == 'not started') {
        $play = new Playoff();
        $all_team = $play->selectTournamentTeam($tournament_id);

        //$team_to_play = array();
        if ($all_team !== false) {


            $update_tournament_status = $tournament->updateTournament($tournament_id, 'running');
            if ($update_tournament_status == true) {


                $play_off_id = $all_team['id'];
                unset($all_team['id']);
                shuffle($all_team); //ramdom sort array
                $team_pair = array_chunk($all_team, 2);
                //$data_to_save = array();

                $final_sql_data = array();
                function rand_score()
                { //rand score => $score_a != $score_b (Playoff)
                    $score_a = (int)rand(0, 5);
                    $score_b = (int)rand(0, 5);
                    if ($score_a == $score_b) {
                        return rand_score();
                    } else {
                        return $score_a . ':' . $score_b;
                    }
                }

                foreach ($team_pair as $val) {
                    $score = '';
                    foreach ($val as $key => $t_val) {
                        switch ($key) {
                            case 0:
                                $a = (int)$t_val;
                                break;
                            case 1:
                                $b = (int)$t_val;
                                break;
                        }
                        //generates the result of the match
                        $score = rand_score();
                    }
                    $data_to_save = array();
                    $data_to_save[] = $play_off_id;
                    $data_to_save[] = (int)$a;
                    $data_to_save[] = (int)$b;
                    $data_to_save[] = '\'' . $score . '\'';
                    $str_result = (explode(':', $score));

                    if ($str_result[0] > $str_result[1]) {
                        $data_to_save[] = (int)$a; //the order of the winner
                        $data_to_save[] = (int)$b; //the order of the loser
                    } else {
                        $data_to_save[] = (int)$b; //the order of the winner
                        $data_to_save[] = (int)$a; //the order of the loser
                    }
                    $sql_str = implode(',', $data_to_save);
                    $u_sql_str = '(' . $sql_str . ')';
                    $final_sql_data[] = $u_sql_str;
                }
                $final_sql = implode(',', $final_sql_data);
                $first_play = $play->orderPlayoff($final_sql);

                if ($first_play == true) {
                    //second tour
                    $first_play_lider = $play->firstPlayLider($play_off_id);
                    if ($first_play_lider == true) {
                        $first_play_winner = array();
                        while ($row = $first_play_lider->fetch_assoc()) {
                            $first_play_winner[] = $row['team_passed'];
                        }

                        shuffle($first_play_winner); //ramdom sort array
                        $team_pair_second = array_chunk($first_play_winner, 2);
                        //$data_to_save = array();

                        $final_sql_data_second = array();
                        /*
                        function rand_score_second(){ //rand score => $score_a != $score_b (Playoff)
                            $score_a = (int)rand(0,5);
                            $score_b = (int)rand(0,5);
                            if($score_a == $score_b){
                                return rand_score_second();
                            } else {
                                return $score_a.':'.$score_b;
                            }
                        }
                        */
                        foreach ($team_pair_second as $val) {
                            $score = '';
                            foreach ($val as $key => $t_val) {
                                switch ($key) {
                                    case 0:
                                        $a = (int)$t_val;
                                        break;
                                    case 1:
                                        $b = (int)$t_val;
                                        break;
                                }
                                //generates the result of the match
                                $score_second = rand_score();
                            }
                            $data_to_save_second = array();
                            $data_to_save_second[] = $play_off_id;
                            $data_to_save_second[] = (int)$a;
                            $data_to_save_second[] = (int)$b;
                            $data_to_save_second[] = '\'' . $score_second . '\'';
                            $str_result = (explode(':', $score_second));

                            if ($str_result[0] > $str_result[1]) {
                                $data_to_save_second[] = (int)$a; //the order of the winner
                                $data_to_save_second[] = (int)$b; //the order of the loser
                            } else {
                                $data_to_save_second[] = (int)$b; //the order of the winner
                                $data_to_save_second[] = (int)$a; //the order of the loser
                            }
                            $sql_str = implode(',', $data_to_save_second);
                            $u_sql_str_second = '(' . $sql_str . ')';
                            $final_sql_data_second[] = $u_sql_str_second;
                        }
                        $final_sql_second = implode(',', $final_sql_data_second);
                        $first_play_second = $play->orderPlayoffSecond($final_sql_second);
                        if ($first_play_second == true) {
                            //third tour
                            $second_play_lider = $play->secondPlayLider($play_off_id);
                            if ($second_play_lider == true) {
                                $second_play_winner = array();
                                while ($row = $second_play_lider->fetch_assoc()) {
                                    $second_play_winner[] = $row['team_passed'];
                                }

                                shuffle($second_play_winner); //ramdom sort array
                                $team_pair_second_second = array_chunk($second_play_winner, 2);
                                //$data_to_save = array();

                                $final_sql_data_second_second = array();
                                /*
                                function rand_score_second(){ //rand score => $score_a != $score_b (Playoff)
                                    $score_a = (int)rand(0,5);
                                    $score_b = (int)rand(0,5);
                                    if($score_a == $score_b){
                                        return rand_score_second();
                                    } else {
                                        return $score_a.':'.$score_b;
                                    }
                                }
                                */
                                foreach ($team_pair_second_second as $val) {
                                    $score = '';
                                    foreach ($val as $key => $t_val) {
                                        switch ($key) {
                                            case 0:
                                                $a = (int)$t_val;
                                                break;
                                            case 1:
                                                $b = (int)$t_val;
                                                break;
                                        }
                                        //generates the result of the match
                                        $score_second_second = rand_score();
                                    }
                                    $data_to_save_second_second = array();
                                    $data_to_save_second_second[] = $play_off_id;
                                    $data_to_save_second_second[] = (int)$a;
                                    $data_to_save_second_second[] = (int)$b;
                                    $data_to_save_second_second[] = '\'' . $score_second_second . '\'';
                                    $str_result = (explode(':', $score_second_second));

                                    if ($str_result[0] > $str_result[1]) {
                                        $data_to_save_second_second[] = (int)$a; //the order of the winner
                                        $data_to_save_second_second[] = (int)$b; //the order of the loser
                                    } else {
                                        $data_to_save_second_second[] = (int)$b; //the order of the winner
                                        $data_to_save_second_second[] = (int)$a; //the order of the loser
                                    }
                                    $sql_str = implode(',', $data_to_save_second_second);
                                    $u_sql_str_second_second = '(' . $sql_str . ')';
                                    $final_sql_data_second_second[] = $u_sql_str_second_second;
                                }
                                $final_sql_second_second = implode(',', $final_sql_data_second_second);
                                $first_play_second_second = $play->orderPlayoffThird($final_sql_second_second);
                                if ($final_sql_data_second_second == true) {
                                    //final play

                                    //second tour
                                    $third_play_lider = $play->thirdPlayLider($play_off_id);
                                    if ($third_play_lider == true) {
                                        $third_play_winner = array();
                                        while ($row = $third_play_lider->fetch_assoc()) {
                                            $third_play_winner[] = $row['team_passed'];
                                        }

                                        shuffle($third_play_winner); //ramdom sort array
                                        $team_pair_third = array_chunk($third_play_winner, 2);
                                        //$data_to_save = array();

                                        $final_sql_data_third = array();
                                        /*
                                        function rand_score_second(){ //rand score => $score_a != $score_b (Playoff)
                                            $score_a = (int)rand(0,5);
                                            $score_b = (int)rand(0,5);
                                            if($score_a == $score_b){
                                                return rand_score_second();
                                            } else {
                                                return $score_a.':'.$score_b;
                                            }
                                        }
                                        */
                                        foreach ($team_pair_third as $val) {
                                            $score = '';
                                            foreach ($val as $key => $t_val) {
                                                switch ($key) {
                                                    case 0:
                                                        $a = (int)$t_val;
                                                        break;
                                                    case 1:
                                                        $b = (int)$t_val;
                                                        break;
                                                }
                                                //generates the result of the match
                                                $score_third = rand_score();
                                            }
                                            $data_to_save_third = array();
                                            $data_to_save_third[] = $play_off_id;
                                            $data_to_save_third[] = (int)$a;
                                            $data_to_save_third[] = (int)$b;
                                            $data_to_save_third[] = '\'' . $score_third . '\'';
                                            $str_result = (explode(':', $score_third));

                                            if ($str_result[0] > $str_result[1]) {
                                                $data_to_save_third[] = (int)$a; //the order of the winner
                                                $data_to_save_third[] = (int)$b; //the order of the loser
                                            } else {
                                                $data_to_save_third[] = (int)$b; //the order of the winner
                                                $data_to_save_third[] = (int)$a; //the order of the loser
                                            }
                                            $sql_str = implode(',', $data_to_save_third);
                                            $u_sql_str_third = '(' . $sql_str . ')';
                                            $final_sql_data_third[] = $u_sql_str_third;
                                        }
                                        $final_sql_third = implode(',', $final_sql_data_third);
                                        $final_play_third = $play->orderPlayoffFinal($final_sql_third);

                                        if ($final_play_third == true) {
                                            $end_tournament_status = $tournament->updateTournament($tournament_id,'end');
                                            if($end_tournament_status == true) {

                                                $free_tournament_team = $play->selectTournamentTeam($tournament_id);

                                                if($free_tournament_team == true) { //free team status -> team can play again
                                                    $free_t_team = array();
                                                    unset($free_tournament_team['id']);
                                                    echo '<pre>';
                                                    print_r($free_tournament_team);
                                                    echo '</pre>';
                                                    foreach($free_tournament_team as $val){
                                                        $free_t_team[] = '(' . $val . ',' . '0' . ')';
                                                    }
                                                    $sql_data_free_team = implode(',', $free_t_team);
                                                    $user = new User();
                                                    $free_team = $user->teamTournament($sql_data_free_team);
                                                    if($free_team == true){

                                                        //Need to add score




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

                                            } else {
                                                $_SESSION['user_info'] = 'Error please try again!';
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
        }else{
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