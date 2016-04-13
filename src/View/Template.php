<?php

namespace View;

/**
 * Class Templater
 * Used for creating html pages out of templates
 * Supports:
 *      {object}                    =>      $object
 *      {object:property}           =>      $object->property
 *      {object->function}          =>      $object->function()
 *      [array]                     =>      foreach($object as $o) $o
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

    private static $VAR_PAT = "\\{([\\w_-]+)(?:((?:\\->)|(?:\\:))(\\w+))?\\}";
    private static $FOR_PAT = "\\[([\\w_-]+)(?:((?:\\->)|(?:\\:))(\\w+))?\\]";
    private static $IF_PAT = '\\?\\?' . '(?P<test>[^\\:]+)' . '::' . '(?P<then>[^\\|]+)'
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

            if (count($matches) < 3)
                return $var;
            else
                return $eval_func($var, $type, $func_or_prop);
        };

        $for_replace = function ($matches) use ($eval_func) {
            $var_name = $matches[1];
            $type = $matches[2];
            $func_or_prop = $matches[3];

            if (!isset($this->params[$var_name]))
                return "missing param: $var_name";

            $var = $this->getParam($var_name);
            $ret = "";

            if (is_array($var)) {
                if (count($matches) < 3)
                    foreach ($var as $v) $ret .= $v . "\n";
                else
                    foreach ($var as $v) $ret .= $eval_func($v, $type, $func_or_prop) . "\n";
            } else {

            }
            
            return $ret;
        };

        $if_replace = function ($matches) {
            $if = array_map('trim', elements(['test', 'then', 'else'], $matches, ''));
            $if['test'] = element($if['test'], $this->params, false);
            return $if['test'] ? $if['then'] : $if['else'];
        };

        $tmp = file_get_contents($this->template);
        $tmp = preg_replace_callback('@' . self::$IF_PAT . '@', $if_replace, $tmp);
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