<?php

namespace src\Exceptions;

use Exception;

abstract class CustomException extends Exception{

    public function __construct( string $error)
    {
        $this->error = $error;
    }

    protected $error;

    public function setError(string $error){
        $this->error = $error;
    }

    public function getError(){
        return $this->error;
    }

    abstract public function getResult();
}

?>