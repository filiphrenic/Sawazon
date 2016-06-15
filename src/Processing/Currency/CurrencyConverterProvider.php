<?php

namespace Processing\Currency;

class CurrencyConverterProvider
{
    /** @var  CurrencyConverter */
    private static $instance;

    public static function get()
    {
        if (self::$instance == null) {
//            self::$instance = new HardcodedCurrencyConverter();
            self::$instance = new HNBCurrencyConverter();
        }
        return self::$instance;
    }
}