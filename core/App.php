<?php

include_once _CORE_.'Controller.php';

class App{
    
    public static $controller;
    public static $action;
    

    public static function run(){

        if (isset($_GET['r']))  {
            $query = explode('/', $_GET['r']);
            
            self::$controller = $query[0];
            self::$action = $query[1];

            self::makeCamelCase();
            Controller::launchAction();
        }
    }

    private static function makeCamelCase(){
        self::$controller = self::toCamelCase(self::$controller);
        self::$action = self::toCamelCase(self::$action);
    }

    private static function toCamelCase($string){
        $explodedString = explode("-", $string);
        if (count($explodedString) > 1)  {
            $parsedString = [];
            foreach ($explodedString as $value) {
                $parsedString [] = ucfirst($value);
            }
            return implode($parsedString);
        }
        return $string;
    }
}
