<?php

namespace src\Controllers;

abstract class ResponseController {
    
    protected static function sendJSON($JSON){
        header("content-Type: application/json; charset=utf-8");
        header("Access-Control-Allow-Origin: *");
        echo $JSON;
    }

}
    

?>