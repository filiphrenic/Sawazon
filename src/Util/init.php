<?php

// add helper functions
require_once "func.php";

// register my autoloader
$my_autoload = function ($classname) {
    $src = __DIR__ . "/../";
    $fileName = $src . str_replace("\\", "/", $classname) . ".php";
    if (!is_readable($fileName)) return false;
    require_once $fileName;
    return true;
};
spl_autoload_register($my_autoload);

//start session
session_start();

// require composer's autoloader
require_once __DIR__ . "/../../vendor/autoload.php";

// load routes
$routes = __DIR__ . "/../../conf/routes.yaml";
\Routing\DefaultRoute::registerFromYML($routes);
