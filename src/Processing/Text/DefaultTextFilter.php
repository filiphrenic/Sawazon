<?php

namespace Processing\Text;

use Symfony\Component\Yaml\Yaml;

class DefaultTextFilter implements TextFilter
{

    /**
     * @var TextFilter
     */
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DefaultTextFilter();
        }
        return self::$instance;
    }

    /**
     * @var array
     */
    private $filters;

    private function __construct()
    {
        $fltrs = __DIR__ . "/../../../conf/text_filter.yaml";
        $this->filters = Yaml::parse(file_get_contents($fltrs));
    }

    private function prepareRegex($regex)
    {
        $arr = ['(', ')', '[', ']', '{', '}', '.', '^', '$', '*', '?', '!', '+'];
        foreach ($arr as $x) {
            $patterns[] = "%\\$x%";
            $replacements[] = "\\$x";
        }
        return preg_replace($patterns, $replacements, $regex) ?: $regex;
    }


    public function apply($text = "")
    {
        foreach ($this->filters['single'] as $p => $r) {
            $patterns[] = "!" . $this->prepareRegex($p) . "!";
            $replacements[] = $r;
        }
        foreach ($this->filters['double'] as $p => $x) {
            $reg = $this->prepareRegex($p);
            $patterns[] = "!" . $reg . "(.+)" . $reg . "!U";
            $replacements[] = $x['start'] . "$1" . $x['end'];
        }
        return preg_replace($patterns, $replacements, $text) ?: $text;
    }
}