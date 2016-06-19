<?php
require_once ("Validation.php");

class Play extends Validation
{
    private $value = array();
    private $sql_value;
    public function teamRegist($team,$tour_id){
        foreach ($team as $val){
            $this->value[] = '('.$val.','.$tour_id.')';
        }
        $this->sql_value = implode(", ", $this->value);

        $sql = "INSERT INTO `play`(team_id,tournament_id) VALUES $this->sql_value";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function checkTournamentTeam($id){
        $sql = "SELECT tournament_id FROM play WHERE tournament_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query) == 16) {
            return false;
        } else {
            return true;
        }
    }
    public function selectTournamentTeam($id){
        $sql = "SELECT id,team_id FROM play WHERE tournament_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query) > 0) {
            return $query;
        } else {
            return false;
        }
    }
    public function addPlayTeam($tournament_id,$team_id,$team_to_play){
        $x = 0;
        $p = 1;
        $result = array();
        foreach($team_id as $val){
            $team_to_play[$x] = 'p'.$p.'=0';
            $this->sql_value = implode(",", $team_to_play);
            $team_to_play[$x] = 'p'.$p.'='.$val;
            $x++;
            $p++;
            $sql = "UPDATE `play` SET $this->sql_value  WHERE team_id = $val and tournament_id = $tournament_id";
            $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
            $result[] = $query;
        }
        return $result;
    }
    public function selectAllPLayTeam($tournament_id){
        $sql = "SELECT * FROM play WHERE tournament_id = $tournament_id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
    public function tournamentTeam($tournament_id){
        $sql = "SELECT team_id FROM play WHERE tournament_id = $tournament_id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
    public function orderPlay($array){
        $result = array();
        $t = 0;
        $t_play_one_id = '';
        $first_team ='';
        $final_sql_data = array();
        while ($row = $array->fetch_assoc()) {
            $all_games = array();
            $t_play_one_id = $row['id'];
            $first_team = $row['team_id'];
            $tournament_id = $row['tournament_id'];
            unset($row['team_id']);
            unset($row['id']);
            unset($row['tournament_id']);
            $clear_array = array_filter($row); //clear empty slot
            foreach ($clear_array as $key=>$val){
                $all_games[][] = $first_team;
                $all_games[$t][] = $val;
                $t++;
            }
            foreach ($all_games as $val) {
                $score = '';  //play score
                foreach ($val as $key => $t_val) {
                    switch ($key) {
                        case 0:
                            $a = (int)$t_val;
                            break;
                        case 1:
                            $b =(int)$t_val;
                            break;
                    }
                    //generates the result of the match
                    $scor_a = rand(0, 5);
                    $scor_b = rand(0, 5);
                    $score = $scor_a . ':' . $scor_b;
                }
                $data_to_save = array();

                $data_to_save[] = (int)$t_play_one_id;
                $data_to_save[] = (int)$a;
                $data_to_save[] = (int)$b;
                $data_to_save[] = '\''.$score.'\'';
                $str_result = (explode(':',$score));
                if($str_result[0] > $str_result[1]){
                    $data_to_save[] = (int)$a; //the order of the winner
                    $data_to_save[] = (int)$b; //the order of the loser
                    $data_to_save[] = (int)$tournament_id;
                } elseif($str_result[0] < $str_result[1]){
                    $data_to_save[] = (int)$b; //the order of the winner
                    $data_to_save[] = (int)$a; //the order of the loser
                    $data_to_save[] = (int)$tournament_id;
                } elseif($str_result[0] == $str_result[1]){
                    $data_to_save[] = '\'drow\'';
                    $data_to_save[] = '\'drow\'';
                    $data_to_save[] = (int)$tournament_id;
                }
                $sql_str = implode(',', $data_to_save);
                $u_sql_str = '('.$sql_str.')';
                $final_sql_data[] = $u_sql_str;

            }
        }
        $final_sql = implode(',', $final_sql_data);
        $sql = "INSERT INTO `order play`(play_id,a,b,score,winner,loser,tournament_id) VALUES $final_sql";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function playScore($tournament_id){

        $sql = "SELECT winner,count(*) as win_number FROM `order play` where winner <> 'drow' and loser <> 'drow' and tournament_id = $tournament_id GROUP BY winner";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public  function playResult($id){
        $sql = "SELECT `order play`.a,user.name,user.s_name,`order play`.b, test.name as b_name,test.s_name as b_s_name,`order play`.`score`
                FROM `order play` INNER JOIN user on `order play`.a = user.id INNER JOIN user as test on `order play`.b = test.id WHERE tournament_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
}