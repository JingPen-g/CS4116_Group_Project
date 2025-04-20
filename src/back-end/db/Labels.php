<?php

require_once("Model.php");

class Labels extends Model {
    protected $table = "Labels";

    public function findAll() {
        return $this->fetchAll();
    }
}