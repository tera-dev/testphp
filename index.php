<?php


//перенаправление с index.php
if($_SERVER['REQUEST_URI'] == "/index.php") {
    header("Location: /index.php?r=user/index");
    exit();
}

//загрузка констант
include_once './config.php';

include_once _CORE_.'App.php';

App::run();
//include './helpers/Url.php';
//
//echo Url::toRoute('user/view');


