<?php

namespace View;

/**
 * Class Templater
 * Used for creating html pages out of templates
 * Supports:
 *      {object:property}       =>      $object->property
 *      {object->function}      =>      $object->function()
 *      [array:property]        =>      foreach($object as $o) $o->property
 *      [array->function]       =>      foreach($object as $o) $o->function()
 * All of these need to return a string.
 *
 * @package View
 */
class Templater
{

    private static $VAR_PAT = "\\{(\\w+)([:\\->]{1,2})(\\w+)\\}";
    private static $FOR_PAT = "\\[(\\w+)([:\\->]{1,2})(\\w+)\\]";

    /** @var  string */
    private $content;

    /** @var array */
    private $params;

    public function __construct($template_name, $params = [])
    {
        $path = __DIR__ . "/Templates/" . $template_name . ".phtml";
        if (!file_exists($path)) $this->content = "<h1>No template for $template_name</h1>";
        else $this->content = file_get_contents($path);
        $this->params = $params;
    }

    /**
     * THIS SHOULD HOPEFULLY BE THE ONLY `ECHO` IN THE PROJECT!
     */
    public function render()
    {
        echo $this->__toString();
    }

    public function __toString()
    {
        $eval_func = function ($var, $type, $func_or_prop) {
            $error = "ERROR FIXME"; // TODO remove when production

            if (':' === $type) {
                if (!property_exists($var, $func_or_prop)) return $error;
                else return $var->$func_or_prop;
            } else if ('->' == $type) {
                if (!method_exists($var, $func_or_prop)) return $error;
                else return $var->$func_or_prop();
            } else return $error;
        };

        $var_replace = function ($matches) use ($eval_func) {
            $var_name = $matches[1];
            $type = $matches[2];
            $func_or_prop = $matches[3];

            if (null == ($var = $this->getParam($var_name))) return "missing param: $var_name";

            return $eval_func($var, $type, $func_or_prop);
        };

        $for_replace = function ($matches) use ($eval_func) {
            $var_name = $matches[1];
            $type = $matches[2];
            $func_or_prop = $matches[3];

            if (null == ($var = $this->getParam($var_name))) return "missing param: $var_name";

            $ret = "";
            if (is_array($var)) {
                foreach ($var as $v) $ret .= $eval_func($v, $type, $func_or_prop) . "\n";
            }
            return $ret;
        };

        $tmp = preg_replace_callback('@' . self::$VAR_PAT . '@', $var_replace, $this->content);
        return preg_replace_callback('@' . self::$FOR_PAT . '@', $for_replace, $tmp);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getParam($key, $default = null)
    {
        return element($key, $this->params, $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }


}