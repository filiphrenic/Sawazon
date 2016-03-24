<?php

require_once "src/Util/init.php";

try {
    \Dispatch\Dispatcher::getInstance()->dispatch();
} catch (Exception $e) {
    // TODO redirect to 404
    echo $e;
    //var_dump($e);
}
