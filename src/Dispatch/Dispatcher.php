<?php

namespace Dispatch;

abstract class Dispatcher
{

    /** @var  Dispatcher */
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DefaultDispatcher();
        }
        return self::$instance;
    }

    public abstract function dispatch();

}