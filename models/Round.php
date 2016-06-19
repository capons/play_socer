<?php
require_once ("Validation.php");

class Round extends Validation
{
    public function selectRound(){
        $sql = "SELECT * FROM round";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }


}