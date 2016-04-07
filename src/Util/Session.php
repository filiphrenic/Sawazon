<?php

namespace Util;

class Session
{
    public static $USER_ID = 'user_id';
    public static $BG_COLOR = 'bg_color';
    public static $CURRENCY = 'currency';
    public static $CAPTCHA = 'captcha';
    public static $LAST_URL = 'last_url';


    public static function get($key, $default = null)
    {
        return element($key, $_SESSION, $default);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}