<?php

if($_SERVER['REQUEST_URI'] == "/index.php") {
    header("Location: /index.php?r=user/index");
    exit();
}

include_once './config.php';

include_once _CORE_.'App.php';

App::run();


