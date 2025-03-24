<?php

class Database {
    private static $instance = null;
    private $conn;

    private $config;

    private function __construct(){
        $this->config = require("db_config.php");

        $this->conn = new mysqli(
            $this->config["DB_HOST"], 
            $this->config["DB_USER"], 
            $this->config["DB_PASSWORD"], 
            $this->config["DB_NAME"]);

        if($this->conn->connect_error){
            die("Connection Failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->conn;
    }
}

?>