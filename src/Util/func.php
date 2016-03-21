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
