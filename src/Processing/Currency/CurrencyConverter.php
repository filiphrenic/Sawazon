<?php

namespace Processing\Currency;

interface CurrencyConverter
{

    /**
     * @param $amount
     * @param string $from_curr
     * @param string $to_curr
     * @return double
     */
    public function convert($amount, $from_curr = 'HRK', $to_curr = 'HRK');

    /**
     * @return array
     */
    public function getValidCurrencies();
}