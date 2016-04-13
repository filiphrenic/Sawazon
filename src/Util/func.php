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

function redirectToLast()
{
    $url = \Util\Session::get(\Util\Session::$LAST_URL);
    redirect($url);
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

/**
 * @return null | \Sawazon\Model
 */
function user()
{
    $user_id = \Util\Session::get(\Util\Session::$USER_ID);
    if ($user_id == null) return null;
    return (new \Model\User())->load($user_id);
}

function cleanHTML($text = "")
{
    return htmlentities($text, ENT_QUOTES, "utf-8");
}

function cleanAll($keys = [], $arr = [], $default = '')
{
    return array_map('cleanHTML', elements($keys, $arr, $default));
}

function shorten($text, $len)
{
    if (mb_strlen($text) <= $len) return $text;
    else return mb_substr($text, 0, $len) . "...";
}

function nounsp($noun, $count)
{
    $ret = $count . ' ' . $noun;
    if ($count == 1) return $ret;
    else return $ret . 's';
}

function hashPass($password)
{
    return sha1($password);
}

function echoJson($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
}

function getPrice($amount)
{
    $currency = \Util\Session::get(\Util\Session::$CURRENCY, 'HRK');
    $cc = \Processing\Currency\CurrencyConverterProvider::get();
    $price = $cc->convert($amount, 'HRK', $currency);
    return "$price $currency";
}

