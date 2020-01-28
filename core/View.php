<?php

class View{
    
    public static function render($view, $data){
        ob_start();
        if ($data !== null) {
            extract($data);
        }
        include_once _VIEWS_DIR_.App::$controller."/".$view.".php";
        ob_get_flush();
    }    
}
