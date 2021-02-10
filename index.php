<?php


// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
    // whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}

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