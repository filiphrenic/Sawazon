<?php

namespace View;

/**
 * Class Templater
 * Used for creating html pages out of templates
 * Supports:
 *      {object:property}           =>      $object->property
 *      {object->function}          =>      $object->function()
 *      [array:property]            =>      foreach($object as $o) $o->property
 *      [array->function]           =>      foreach($object as $o) $o->function()
 *      ??test :: then || else??    =>      if (test) { then; } else { else; }
 *
 * All of these need to return a string.
 *
 * @package View
 */
class Template
{

    private static $PAR_PAT = "\\(\\(([\\w-]+)\\)\\)";
    private static $VAR_PAT = "\\{(\\w+)([:>-]{1,2})(\\w+)\\}";
    private static $FOR_PAT = "\\[(\\w+)([:>-]{1,2})(\\w+)\\]";
    private static $IF_PAT = '\\?\\?' . '(?P<test>[^?]+)' . '::' . '(?P<then>[^!]+)'
    . '\\|\\|' . '(?P<else>[^?]*)' . '\\?\\?';

    /** @var  string */
    private $template;

    /** @var array */
    private $params;

    public function __construct($template_name)
    {
        $this->template = __DIR__ . "/../Templates/" . $template_name . ".phtml";
        if (!file_exists($this->template)) throw  new \Exception('No file ' . $template_name);
        $this->params = [];
    }

    /**
     * THIS SHOULD HOPEFULLY BE THE ONLY `ECHO` IN THE PROJECT!
     */
    public function render()
    {
        echo $this->toHtml();
    }

    public function toHtml()
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

            if (null == ($var = $this->getParam($var_name)))
                return "missing param: $var_name";

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

        $if_replace = function ($matches) {
            $if = array_map('trim', elements(['test', 'then', 'else'], $matches, ''));
            $if['test'] = element($if['test'], $this->params, false);
            return $if['test'] ? $if['then'] : $if['else'];
        };

        $par_replace = function ($matches) {
            return element($matches[1], $this->params, '');
        };

        $tmp = file_get_contents($this->template);
        $tmp = preg_replace_callback('@' . self::$IF_PAT . '@', $if_replace, $tmp);
        $tmp = preg_replace_callback('@' . self::$PAR_PAT . '@', $par_replace, $tmp);
        $tmp = preg_replace_callback('@' . self::$VAR_PAT . '@', $var_replace, $tmp);
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