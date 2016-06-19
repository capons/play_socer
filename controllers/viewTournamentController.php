<?php
if(isset($_GET['t_if'])){
    $tournament_id = (int)$_GET['t_if'];
    $tournament = new Tournament();
    $check_type = $tournament->tournamentType($tournament_id);
    if($check_type['type'] === 'Tournament table'){
        $play = new Play();
        $play_details = $play->playResult($tournament_id);
        if($play_details == true){
            $tournament_result = array();
            while($row = $play_details->fetch_assoc()){
                $tournament_result[] = $row;
            }

        } else {
            $_SESSION['user_info'] = 'Error please try again';
            header('Location:'.base_path.'viewTournament.php');
            die();
        }
    } elseif($check_type['type'] === 'Playoff'){
        $playoff = new Playoff();
        $play_off_id = $playoff->selectPlayoffId($tournament_id);
        $first_match = $playoff->resultFirstPlay($play_off_id['id']);
        $second_match = $playoff->resultSecondPlay($play_off_id['id']);
        $third_match = $playoff->resultThirdPlay($play_off_id['id']);
        $final_match = $playoff->resultFinalPlay($play_off_id['id']);
    }
}