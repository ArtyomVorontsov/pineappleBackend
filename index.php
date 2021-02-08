<?php

use src\Db;

$routes = require __DIR__ .  "/src/Routes.php";
     

    $route = $_GET["route"];
    $isRouteFound = false;

    spl_autoload_register(function($classPath){
        $classPath = str_replace("\\", "/", $classPath);
        require_once __DIR__  . "/" . $classPath . ".php";
    });

    foreach($routes as $pattern => $controllerAndAction){
        if(preg_match($pattern, $route)){
            $isRouteFound = true;
            break;
        };
    }

    if(!$isRouteFound){
        echo "Route not found";
        return;
    }

    $controller = $controllerAndAction[0];
    $action = $controllerAndAction[1];

    $instance = new $controller();
    $instance->$action()

?>