<?php

namespace View;

class Templater
{

    /** @var  string */
    private $content;

    /**
     * All of the parameters must either be primitives (int, string, ...)
     * or a class with the __toString function.
     * @var array
     */
    public $params;

    // TODO add params set

    public function __construct($template)
    {
        $path = __DIR__ . "/Templates/" . $template . ".phtml";
        $this->content = file_get_contents($path);
        $this->params = ['test' => new TestClass(), 'arr' => [1, 2, 3]];
    }

    public function __toString()
    {
        $THIS = $this;

        // used to replace $var in template
        $variable_replace = function ($matches) use ($THIS) {
            $expr = $matches[1];
            if ($pos = strpos($expr, '->')) {
                $variable = substr($expr, 0, $pos);
                $method_param = substr($expr, $pos + 2);

                if (($obj = element($variable, $THIS->params, null)) == null) return $matches[0];

                if ($pos = strpos($method_param, '()')) { // method
                    $method = substr($method_param, 0, $pos);
                    if (method_exists($obj, $method)) $ret = $obj->$method();
                    else return $matches[0];
                } else {
                    // TODO doesn't work??
                    $ret = $obj->$method_param;
                }
            } else if (($obj = element($expr, $THIS->params, null)) !== null) {
                $ret = $obj;
            } else
                return $matches[0];

            return "\"$ret\"";
        };

        $f = function ($matches) use ($THIS, $variable_replace) {
            var_dump($matches[1]);
            $php_code = preg_replace_callback("%\\$([^\\s;]+)%", $variable_replace, $matches[1]);
            var_dump($php_code);
            ob_start();
            eval($php_code);
            return ob_get_clean();
        };

        // evaluate all <?php tags

        return preg_replace_callback("%<\\?php\\s+(.*)\\s+\\?>%U", $f, $this->content);
    }

    // ideja je recimo u modelu Post napraviti toString na nacin da

    public function render()
    {
        echo $this->__toString();
    }

}