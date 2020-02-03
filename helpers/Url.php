<?php

class Url{
    
    public static function toRoute($route) {
        $routes = explode('/', $route);
        return "/index.php?r={$routes[0]}/{$routes[1]}";
    }
    
}
