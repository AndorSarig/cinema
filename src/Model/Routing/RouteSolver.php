<?php

namespace Model\Routing;


class RouteSolver
{

    public function solve() : void
    {
        require_once 'routes.php';
        $method = $_SERVER['REQUEST_METHOD'];
        $route  = $_SERVER['REQUEST_URI'];
        foreach (ROUTES[$method] as $regex => $toUse) {
            if (preg_match($regex, $route)) {
                $controllerName = $toUse['CONTROLLER'];
                $controller = new $controllerName() ;
                $methodName = $toUse['METHOD'];
                $controller->$methodName();
            }
        }
    }

}