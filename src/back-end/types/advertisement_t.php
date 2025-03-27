<?php

class advertisement_t {
    public $Ad_ID;
    public $Name;
    public $Description;
    public $Business_ID;
    public $Label;

    public function __construct(){
        $this->Ad_ID = 0;
        $this->Name = "";
        $this->Description = "";
        $this->Business_ID = 0;
        $this->Label = [];
    }

    public function set($Ad_ID = 0, $Name = "", $Description = "", $Business_ID = 0, $Label = []){
        $this->Ad_ID = $Ad_ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Business_ID = $Business_ID;
        $this->Label = $Label;
    }
}

?>