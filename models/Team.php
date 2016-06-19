<?php
require_once ("Validation.php");

class Team extends Validation
{
    private $name;
    private $country;
    public function teamRegist($name,$country){
        $this->name = parent::valid($name);
        $this->country = parent::valid($country);
        $sql = "INSERT into team (name,country)
                VALUES ('$this->name','$this->country')";
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
    public function selectAllTeam(){
        $sql = "SELECT * FROM team";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
}