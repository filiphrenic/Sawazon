<?php

require_once "src/Util/init.php";

try {
    \Dispatch\Dispatcher::getInstance()->dispatch();
} catch (\Routing\RoutingException $e) {
    var_dump($e);
//    redirect(\Routing\Route::get('error')->generate(['code' => '404']));
} catch (Exception $e) {
    var_dump($e);
//    redirect(\Routing\Route::get('error')->generate(['code' => '500']));
}


