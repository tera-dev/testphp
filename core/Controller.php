<?php

include_once _CORE_.'View.php';

class Controller{
    
    public static function launchAction(){
//        echo 'launchAction';echo '<br/>';
        if (self::controllerExists()) {
            include_once _CONTROLLERS_DIR_.ucfirst(App::$controller)."Controller.php";
            $controllerClass = ucfirst(App::$controller)."Controller";
            $controllerClassObj = new $controllerClass();
            
            if (self::actionExists($controllerClassObj)) {
                $controllerClassObj->{"action".ucfirst(App::$action)}();
            }
            else{
                echo "Unknown action: " .ucfirst(App::$action). " in controller: ".
                        ucfirst(App::$controller);
            }
        }
        else{
            echo "Unknown controller: " .ucfirst(App::$controller);
        }
        
    }

    protected function redirect($action, $controller = NULL){
        if ($controller === NULL) $controller = App::$controller;
        header("Location: index.php?r={$controller}/{$action}");
        exit();
    }

        private static function controllerExists(){
        return file_exists(_CONTROLLERS_DIR_.ucfirst(App::$controller)."Controller.php");
    }
    
    private static function actionExists($controller){
        return method_exists($controller, 'action'.ucfirst(App::$action));
    }
    
    protected function renderView($view, &$arrays = NULL){
        include_once _LAYOUTS_DIR_.'main.php';
        View::render($view, $arrays);
    }

 
}

