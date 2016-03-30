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
 * Redirects to index page.
 *
 * @param string $error
 */
function strange_behaviour($error = "")
{
    redirect(\Routing\Route::get("index")->generate());
}

