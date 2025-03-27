<?php 

class ComponentBase {
    protected string $templatePath;

    public function __construct(string $templatePath){
        $this->templatePath = $templatePath;
    }
    public function render(){
        include($this->templatePath);
    }
}

?>