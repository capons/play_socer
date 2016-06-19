<?php
require_once ("Validation.php");

class Tournament extends Validation
{
    private $name;
    public function tournamentRegist($id,$name){
        $this->name = parent::valid($name);
        $sql = "INSERT into tournament (name,status,round_id)
                VALUES ('$this->name','not started','$id')";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
        die();
        /*
        if ($query == true) {
            return $last_id = mysqli_insert_id(Database::connect());
        }
        die();
        */
    }
    public function selectTournametn(){
        $sql = "SELECT * FROM tournament";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
    public function tournamentView(){
        $sql = "SELECT tournament.id,`name`, `status`, round.type FROM `tournament`INNER JOIN round on round.id = tournament.round_id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
    public function tournamentType($id){
        $this->name = parent::valid($id);
        $sql = "SELECT round.type FROM tournament INNER JOIN round on tournament.round_id = round.id WHERE tournament.id = $this->name";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return mysqli_fetch_array($query);
        } else {
            return false;
        }
    }
    public function selectTournametnTable(){
        $sql = "SELECT * FROM tournament WHERE round_id = 1";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
    public function selectTournametnPlayoff(){
        $sql = "SELECT * FROM tournament WHERE round_id = 2 ";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
    public function checkTournametn($id){
        $sql = "SELECT * FROM tournament WHERE id = $id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return mysqli_fetch_assoc($query);
        } else {
            return false;
        }
    }
    public function updateTournament($tournament_id,$status){
        $sql = "UPDATE `tournament` SET status='$status'  WHERE id = $tournament_id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function tournamentTeamStatus($tournament_id){
        $sql = "UPDATE tournament SET team = 1 WHERE id = $tournament_id";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public  function tournamentFull($tournament_id){
        $sql = "SELECT * FROM tournament WHERE id = $tournament_id and team = 1";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return true;
        } else {
            return false;
        }
    }
}