<?php

namespace Dispatch;

use Routing\Route;

abstract class Dispatcher
{

    /** @var  Dispatcher */
    private static $instance = null;

    /**
     * @return Dispatcher
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DefaultDispatcher();
        }
        return self::$instance;
    }

    public abstract function dispatch();

    /**
     * @return Route
     */
    public abstract function getRoute();

}