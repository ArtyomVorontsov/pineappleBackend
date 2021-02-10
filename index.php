<?php

use src\Exceptions\CustomException;
use src\Exceptions\NotFoundException;

$routes = require __DIR__ .  "/src/Routes.php";

    try{

        $route = $_GET["route"];
        $isRouteFound = false;

        spl_autoload_register(function($classPath){
            $classPath = str_replace("\\", "/", $classPath);
            require_once __DIR__  . "/" . $classPath . ".php";
        });

        foreach($routes as $pattern => $controllerAndAction){
            if(preg_match($pattern, $route, $matches)){
            
                if(!empty($matches)){
                    $isRouteFound = true;
                    break;
                }
            
            };
        }

        if(!$isRouteFound){
            throw new NotFoundException("Route not found");
        }

        unset($matches[0]);

        $controller = $controllerAndAction[0];
        $action = $controllerAndAction[1];

        $instance = new $controller();
        $instance->$action(...$matches);

    }catch(CustomException $exception){
       $exception->getResult();
    }catch(Exception $exception){
        echo $exception->getMessage();
    }

?>