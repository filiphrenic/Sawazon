<?php

namespace Util;

class Session
{
    public static $USER_ID = 'user_id';
    public static $BG_COLOR = 'bg_color';
    public static $CURRENCY = 'currency';
    public static $CAPTCHA = 'captcha';
    public static $LAST_URL = 'last_url';

    public static function addUser($user)
    {
        self::set(self::$USER_ID, $user->user_id);
        self::set(self::$BG_COLOR, $user->bg_color);
        self::set(self::$CURRENCY, $user->currency);
    }

    public static function removeUser()
    {
        self::del(self::$USER_ID);
        self::del(self::$BG_COLOR);
        self::del(self::$CURRENCY);
    }

    public static function get($key, $default = null)
    {
        return element($key, $_SESSION, $default);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function del($key)
    {
        unset($_SESSION[$key]);
    }
}