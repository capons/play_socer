<?php
//require_once ("../config/const.php");
require_once ("Validation.php");

class User extends Validation
{
    private $name;
    private $s_name;
    private $email;
    private $image;
    private $pass;
    private $redirePath = base_path;
    public function userRegist($name,$s_name,$email,$pass){
        $this->name = parent::valid($name);
        $this->s_name = parent::valid($s_name);
        $this->email = parent::valid($email);
        $this->pass = md5(parent::valid($pass));
        $sql = "INSERT into user (name,s_name,email,pass,access)
                VALUES ('$this->name','$this->s_name','$this->email','$this->pass',1)";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if ($query == true) {
           return $last_id = mysqli_insert_id(Database::connect());

        }
        die();
    }
    public function userImage($id,$image){
        $this->image = parent::valid($image);
        $sql = "INSERT into image (user_id,image_name)
                VALUES ('$id','$image')";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if ($query == true) {
            return true;
        }
        die();
    }
    public function checkEmail($email){
        $this->email = parent::valid($email);
        $sql = "SELECT * FROM user WHERE email = '$this->email'";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return false;
        } else {
            return true;
        }
    }
    public function checkLogin($email,$pass){
        $this->email = parent::valid($email);
        $this->pass = parent::valid($pass);
        $sql = "SELECT user.*,image.image_name 
                FROM user INNER JOIN image on user.id = image.user_id 
                WHERE user.email = '$this->email' and pass='$this->pass'";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return mysqli_fetch_assoc($query);
        } else {
            return false;
        }
    }
    public function selectUser($id){
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return mysqli_fetch_assoc($query);
        } else {
            return false;
        }
    }
    public function update($id,$name,$s_name,$email){
        $this->name = parent::valid($name);
        $this->s_name = parent::valid($s_name);
        $this->email = parent::valid($email);
        $sql = "UPDATE user SET name ='$this->name',s_name ='$this->s_name',email='$this->email' WHERE id = '$id'";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        return $query;
       
    }
    public function checkAccess($id){
        $sql = "SELECT user.access FROM user WHERE id = '$id'";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return mysqli_fetch_assoc($query);
        } else {
            return false;
        }
    }
    public function selectAllUser(){
        $sql = "SELECT * FROM user";
        $query = mysqli_query(Database::connect(), $sql) or die (mysqli_error(Database::connect()));
        if (mysqli_num_rows($query)>0) {
            return $query;
        } else {
            return false;
        }
    }
    public function teamTournament($sql){ // users who are in the tournament or free user from tournament
        $sql_query = "INSERT INTO user (id,is_play) VALUES $sql ON DUPLICATE KEY UPDATE is_play=VALUES(is_play)";
        $query = mysqli_query(Database::connect(), $sql_query) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function teamScore($sql){ // users who are in the tournament or free user from tournament
        $sql_query = "INSERT INTO user (id,score) VALUES $sql ON DUPLICATE KEY UPDATE score=VALUES(score)";
        $query = mysqli_query(Database::connect(), $sql_query) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function selectUpTeam($sql){
        $sql_query = "SELECT * FROM user WHERE id IN ($sql) ";
        $query = mysqli_query(Database::connect(), $sql_query) or die (mysqli_error(Database::connect()));
        return $query;
    }
    public function selectUserScore(){
        $sql_query = "SELECT `id`, `name`, `s_name`, `email`, `score` FROM `user` ORDER BY score DESC";
        $query = mysqli_query(Database::connect(), $sql_query) or die (mysqli_error(Database::connect()));
        return $query;
    }
    
}