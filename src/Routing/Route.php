<?php

namespace Routing;

abstract class Route
{

    /** @var array Routes */
    private static $map = [];

    /**
     * Returns true if this route matches the given url.
     *
     * @param string $url
     * @return bool
     */
    public abstract function matches($url);

    /**
     * @param array $params
     * @return string generated url
     */
    public abstract function generate($params = []);

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public abstract function getParam($key, $default = "");

    /**
     * @return string
     */
    public abstract function getController();

    /**
     * @return string
     */
    public abstract function getAction();

    /**
     * @param string $name
     * @param Route $route
     */
    public static function register($name, $route)
    {
        self::$map[$name] = $route;
    }

    /**
     * @param string $name
     * @return Route | array
     */
    public static function get($name = null)
    {
        if ($name == null) return self::$map;
        return element($name, self::$map, null);
    }

}