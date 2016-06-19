<?php
require_once ("Validation.php");

class Playoff extends Validation
{
    public function checkTournamentTeam($id){
        $sql = "SELECT tournament_id FROM play WHERE tournament_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query) == 16) {
            return false;
        } else {
            return true;
        }
    }
    public function teamRegist($team){

        $data = implode(",",$team);


        $sql = "INSERT INTO `play_off`(t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16,tournament_id) VALUES ($data)";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        //return $query;
        return  mysqli_insert_id(Database::connect());
    }
    public function selectTournamentTeam($id){
        $sql = "SELECT id,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,t13,t14,t15,t16 FROM play_off WHERE tournament_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query) > 0) {
            return mysqli_fetch_assoc($query);
        } else {
            return false;
        }
    }
    public function orderPlayoff($sql_data){
        $sql = "INSERT INTO `first_play`(play_off_id,a,b,result,team_passed,team_out) VALUES $sql_data";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function firstPlayLider($playoff_id){
        $sql = "SELECT team_passed FROM `first_play` where  play_off_id = $playoff_id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function orderPlayoffSecond($sql_data){
        $sql = "INSERT INTO `second_play`(play_off_id,a,b,result,team_passed,team_out) VALUES $sql_data";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function secondPlayLider($playoff_id){
        $sql = "SELECT team_passed FROM `second_play` where  play_off_id = $playoff_id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function orderPlayoffThird($sql_data){
        $sql = "INSERT INTO `third_play`(play_off_id,a,b,result,team_passed,team_out) VALUES $sql_data";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function thirdPlayLider($playoff_id){
        $sql = "SELECT team_passed FROM `third_play` where  play_off_id = $playoff_id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function orderPlayoffFinal($sql_data){
        $sql = "INSERT INTO `final_play`(play_off_id,a,b,result,team_passed,team_out) VALUES $sql_data";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function selectPlayoffId($id){
        $sql = "SELECT id FROM `play_off` where  tournament_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return mysqli_fetch_assoc($query);
    }
    public function resultFirstPlay($id){
        $sql = "SELECT
                first_play.a,user.name,user.s_name,first_play.b,
                test.name as b_name,test.s_name as b_s_name,first_play.`result`,
                testone.name as winer_b_name,testone.s_name as winer_b_s_name
                FROM first_play INNER JOIN user on first_play.a = user.id
                INNER JOIN user as test on first_play.b = test.id
                INNER JOIN user as testone on first_play.b = testone.id WHERE play_off_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function resultSecondPlay($id){
        $sql = "SELECT
                second_play.a,user.name,user.s_name,second_play.b,
                test.name as b_name,test.s_name as b_s_name,second_play.`result`,
                testone.name as winer_b_name,testone.s_name as winer_b_s_name
                FROM second_play INNER JOIN user on second_play.a = user.id
                INNER JOIN user as test on second_play.b = test.id
                INNER JOIN user as testone on second_play.b = testone.id WHERE play_off_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function resultThirdPlay($id){
        $sql = "SELECT
                third_play.a,user.name,user.s_name,third_play.b,
                test.name as b_name,test.s_name as b_s_name,third_play.`result`,
                testone.name as winer_b_name,testone.s_name as winer_b_s_name
                FROM third_play INNER JOIN user on third_play.a = user.id
                INNER JOIN user as test on third_play.b = test.id
                INNER JOIN user as testone on third_play.b = testone.id WHERE play_off_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function resultFinalPlay($id){
        $sql = "SELECT
                final_play.a,user.name,user.s_name,final_play.b,
                test.name as b_name,test.s_name as b_s_name,final_play.`result`,
                testone.name as winer_b_name,testone.s_name as winer_b_s_name
                FROM final_play INNER JOIN user on final_play.a = user.id
                INNER JOIN user as test on final_play.b = test.id
                INNER JOIN user as testone on final_play.b = testone.id WHERE play_off_id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
}