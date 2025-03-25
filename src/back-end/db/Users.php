<?php

require_once("Model.php");

class Users extends Model {
    protected $table = "Users";

    public function getUser($name) {
        return $this->find(['Name' => $name]);
    }

    public function getUserCount(){
        return $this->count();
    }
}

?>