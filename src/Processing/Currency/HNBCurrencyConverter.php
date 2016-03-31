<?php

namespace Processing\Currency;

class HNBCurrencyConverter implements CurrencyConverter
{
    // see http://www.hnb.hr/core-functions/monetary-policy/exchange-rate-list/exchange-rate-list
    /** @var  string */
    private static $url = "http://www.hnb.hr/hnb-tecajna-lista-portlet/rest/tecajn/getformatedrecords.dat";

    // see http://www.hnb.hr/core-functions/monetary-policy/exchange-rate-list/exchange-rate-list/description-of-records
    private static $pattern = '%' . '(?P<code>\\d{3})' . '(?P<currency>\\w{3})' . '(?P<unit>\\d{3})' . '\\s*'
    . '(?P<buying>[^\\s]+)' . '\\s*' . '(?P<middle>[^\\s]+)' . '\\s*' . '(?P<selling>[^\\s]+)' . '%';

    /** @var  array */
    private $currencies;

    public function __construct()
    {
        $this->currencies = ['HRK' => 1.0];

        $handle = fopen(self::$url, "r");
        if ($handle) {
            fgets($handle); // header
            while (($line = fgets($handle)) !== false) {
                $m = [];
                preg_match(self::$pattern, $line, $m);
                $value = doubleval(preg_replace('/,/','.', $m['middle']));
                $this->currencies[$m['currency']] = $value;
            }
            fclose($handle);
        } else {
        }
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

    public function getValidCurrencies()
    {
        return array_keys($this->currencies);
    }
}