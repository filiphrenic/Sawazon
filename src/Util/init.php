<?php

$base = __DIR__ . "/../../";

// add helper functions
require_once "func.php";

// register my autoloader
$my_autoload = function ($classname) use ($base) {
    $fileName = $base . "src/" . str_replace("\\", "/", $classname) . ".php";
    if (!is_readable($fileName)) return false;
    require_once $fileName;
    return true;
};
spl_autoload_register($my_autoload);

//start session
session_start();

// require composer's autoloader
require_once $base . "vendor/autoload.php";

// load routes
\Routing\DefaultRoute::registerFromYML($base . "conf/routes.yaml");
