<?php

namespace Dispatch;

use Routing\Route;
use Routing\RoutingException;

class DefaultDispatcher extends Dispatcher
{

    public function dispatch()
    {
        $uri = $_SERVER["REQUEST_URI"];
        if ($pos = strpos($uri, "?") !== false) $uri = substr($uri, 0, $pos);

        $route = null;

        /** @var Route $r */
        foreach (Route::get() as $r) {
            if ($r->matches($uri)) {
                $route = $r;
                break;
            }
        }

        if ($route == null) throw new RoutingException("Route not found");

        $ctl = $route->getController();
        $ctlCls = "\\Controller\\" . implode('\\', array_map('ucfirst', explode('/', $ctl)));
        if (!class_exists($ctlCls)) throw new RoutingException("Controller $ctl not found");

        $action = $route->getAction();
        if (!is_callable([$ctlCls, $action]))
            throw new RoutingException("Action $action not found in controller $ctl");

        call_user_func([$ctlCls, $action]);
    }
}