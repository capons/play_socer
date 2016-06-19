<?php
class Database
{
    private static $_host = "localhost";
    private static $_username = "user";
    private static $_password = "11111";
    private static $_database = "la-tt";
    private static $instance;
    private function __construct() { }
    private function __clone() { }
    public static function connect () 
    {
        if(!isset(self::$instance)) {
            self::$instance = new MySQLi(self::$_host, self::$_username, self::$_password, self::$_database);
            if(self::$instance->connect_error) {
                throw new Exception('MySQL connection failed: ' . self::$instance->connect_error);
            }
        }
        return self::$instance;
    }
}
