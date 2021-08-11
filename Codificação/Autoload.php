<?php

class Autoload {

	private $diretorio;

    public function __construct($dir){
    	$this->diretorio = $dir;
        spl_autoload_register(array($this, 'loader'));
    }

    private function loader($className){
        //echo 'Trying to load ', $className, ' via ', __METHOD__, "()\n";
        include_once $this->diretorio . $className . '.php';
    }

}