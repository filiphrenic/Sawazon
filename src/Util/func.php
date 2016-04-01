<?php

/**
 * @param string $needle
 * @param array $haystack
 * @param mixed $default
 * @return mixed
 */
function element($needle, $haystack, $default = null)
{
    if ($haystack == null) {
        return $default;
    }
    if ($needle == null) {
        return $default;
    }
    return isset($haystack[$needle]) ? $haystack[$needle] : $default;
}

/**
 * @param array $needles
 * @param array $haystack
 * @param mixed $default
 * @return array
 */
function elements($needles, $haystack, $default = null)
{
    $elms = array();
    foreach ($needles as $needle) {
        $elms[$needle] = element($needle, $haystack, $default);
    }
    return $elms;
}

/**
 * @param mixed $obj
 * @return string short class name (without namespace)
 */
function short_name($obj)
{
    $class_name = get_class($obj);
    if ($pos = strrpos($class_name, '\\'))
        $class_name = substr($class_name, $pos + 1);
    return $class_name;
}

/**
 * @return string url base for this server
 */
function url_base()
{
    return $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"];
}

/**
 * Redirects to given url
 * @param string $url
 */
function redirect($url = "/")
{
    header("Location: $url");
    die();
}

/**
 * Function is called when something strange happens,
 * but I don't want to throw an exception.
 * Maybe log the error somewhere and redirect to index page.
 *
 * @param string $error
 */
function strange_behaviour($error = "")
{
    redirect(\Routing\Route::get("index")->generate());
}

/**
 * will transform this:
 *
 * array(1) {
 *      ["upload"]=>array(2) {
 *          ["name"]=>array(2) {
 *              [0]=>string(9)"file0.txt"
 *              [1]=>string(9)"file1.txt"
 *              }
 *          ["type"]=>array(2) {
 *              [0]=>string(10)"text/plain"
 *              [1]=>string(10)"text/html"
 *              }
 *          }
 *      }
 *
 * into:
 *
 * array(1) {
 *      ["upload"]=>array(2) {
 *          [0]=>array(2) {
 *              ["name"]=>string(9)"file0.txt"
 *              ["type"]=>string(10)"text/plain"
 *              },
 *          [1]=>array(2) {
 *              ["name"]=>string(9)"file1.txt"
 *              ["type"]=>string(10)"text/html"
 *              }
 *          }
 *      }
 * @param $arr
 * @return array rearranged
 */
function rearrange_array($arr)
{
    $result = [];
    foreach ($arr as $k1 => $v1) {
        foreach ($v1 as $k2 => $v2) {
            $result[$k2][$k1] = $v2;
        }
    }
    return $result;
}

