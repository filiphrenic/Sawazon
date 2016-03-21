<?php

namespace Routing;

use Symfony\Component\Yaml\Yaml;
use Util\Config;

class DefaultRoute extends Route
{

    private static $PATTERN = "/<[a-z0-9_]+>/iu";

    /** @var  string */
    private $match_regex;

    /** @var  string */
    private $regex;

    /** @var  string */
    private $controller;

    /** @var  string */
    private $action;

    /** @var  array */
    private $default_params;

    /** @var  array */
    private $params;

    /**
     * @param array $route
     * @return DefaultRoute
     */
    private static function fromYML($route)
    {
        return new DefaultRoute(
            element('url', $route, ''),
            element('controller', $route, ''),
            element('action', $route, ''),
            element('defaults', $route, []),
            element('regexs', $route, [])
        );
    }

    /**
     * @param string $path path to file
     */
    public static function registerFromYML($path)
    {
        $routes = Yaml::parse(file_get_contents($path));

        foreach ($routes as $route_name => $r) {
            $route = DefaultRoute::fromYML($r);
            self::register($route_name, $route);
        }
    }

    /**
     * @param string $url
     * @param string $controller
     * @param string $action
     * @param array $defaults
     * @param array $regexs
     */
    private function __construct($url, $controller, $action, $defaults = [], $regexs = [])
    {
        $f = function ($match) use ($regexs) {
            $name = substr($match[0], 1, -1); // take the name
            $reg = element($name, $regexs, ".+?");
            return "(?P" . $match[0] . $reg . ")";
        };

        $basepath = Config::get()['basepath'];
        $this->regex = $basepath . $url;
        $this->match_regex = "@^" . preg_replace_callback(self::$PATTERN, $f, $this->regex) . "$@uD";

        $this->controller = $controller;
        $this->action = $action;
        $this->default_params = $defaults;
        $this->params = [];
    }


    public function matches($url)
    {
        return (bool)preg_match($this->match_regex, $url, $this->params);
    }

    public function generate($params = [])
    {
        $params = array_merge($this->default_params, $params);
        $f = function ($match) use ($params) {
            $name = substr($match[0], 1, -1); // take the name
            $reg = element($name, $params, null);
            if ($reg == null) throw new RoutingException("Parameter $name wasn't provided");
            return $reg;
        };

        return preg_replace_callback(self::$PATTERN, $f, $this->regex);
    }

    public function getParam($key, $default = "")
    {
        return element($key, $this->params, $default);
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

}


