<?php

namespace Dispatch;

use Routing\Route;
use Routing\RoutingException;
use Util\Session;

class DefaultDispatcher extends Dispatcher
{

    /** @var  Route */
    private $route;

    public function dispatch()
    {
        $uri = $_SERVER["REQUEST_URI"];
        if ($pos = strpos($uri, "?") !== false) $uri = substr($uri, 0, $pos);

        /** @var Route $r */
        foreach (Route::get() as $r) {
            if ($r->matches($uri)) {
                $this->route = $r;
                break;
            }
        }

        if ($this->route == null) throw new RoutingException("Route for $uri not found");

        if ($this->route->getRemember())
            Session::set(Session::$LAST_URL, $uri); // redirect after signup or ...

        $ctl = $this->route->getController();
        $ctlCls = "\\Controller\\" . implode('\\', array_map('ucfirst', explode('/', $ctl)));
        if (!class_exists($ctlCls)) throw new RoutingException("Controller $ctl not found");

        $action = $this->route->getAction();
        if (!is_callable([$ctlCls, $action]))
            throw new RoutingException("Action $action not found in controller $ctl");

        call_user_func([$ctlCls, $action]);
    }

    public function getRoute()
    {
        return $this->route;
    }
}