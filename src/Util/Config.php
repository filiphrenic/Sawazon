<?php

namespace Util;

use Symfony\Component\Yaml\Yaml;

class Config
{

    private static $conf_path = __DIR__ . "/../../conf/conf.yaml";

    /** @var  array */
    public static $configuration = null;

    /**
     * @return array
     */
    public static function get()
    {
        if (self::$configuration == null) {
            self::$configuration = Yaml::parse(file_get_contents(self::$conf_path));
        }
        return self::$configuration;
    }
}