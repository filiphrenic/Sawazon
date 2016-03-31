<?php

namespace Processing\Currency;

class HardcodedCurrencyConverter implements CurrencyConverter
{

    /** @var  array */
    private $currencies;

    public function __construct()
    {
        $this->currencies = [
            'HRK' => 1.000000,
            'AUD' => 5.073403,
            'CAD' => 5.107864,
            'CZK' => 0.278068,
            'DKK' => 1.009206,
            'HUF' => 2.393925,
            'JPY' => 5.884957,
            'NOK' => 0.798136,
            'SEK' => 0.813637,
            'CHF' => 6.872416,
            'GBP' => 9.512711,
            'USD' => 6.616628,
            'EUR' => 7.519798,
            'PLN' => 1.762315
        ];
    }

    /**
     * @param $amount
     * @param string $from_curr
     * @param string $to_curr
     * @return double
     */
    public function convert($amount, $from_curr = 'HRK', $to_curr = 'HRK')
    {
        $to = element($to_curr, $this->currencies, 1);
        $from = element($from_curr, $this->currencies, 1);

        return $amount * $from / $to;
    }

    /**
     * @return array
     */
    public function getValidCurrencies()
    {
        return array_keys($this->currencies);
    }

}