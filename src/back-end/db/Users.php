<?php

class Users extends Model {
    protected $table = "Users";

    public function getUser($name) {
        return $this->find($name, "Name");
    }
}

?>