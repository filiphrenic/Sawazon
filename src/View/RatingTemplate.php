<?php

namespace View;

class RatingTemplate
{

    private static $N = 5;

    /** @var int */
    private $n;

    public function __construct($n)
    {
        if ($n < 1 || $n > self::$N) $n = 0;
        $this->n = $n;
    }

    public function toHtml()
    {
        $ret = "";
        for ($i = 0; $i < $this->n; $i++) {
            $ret .= "<span class=\"glyphicon glyphicon-star\"></span>";
        }
        for ($i = $this->n; $i < self::$N; $i++) {
            $ret .= "<span class=\"glyphicon glyphicon-star-empty\"></span>";
        }
        return $ret;
    }
}