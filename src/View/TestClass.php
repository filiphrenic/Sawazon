<?php

namespace View;

class TestClass
{

    public $property;

    public function __construct($x)
    {
        $this->property = $x;
    }

    public function x()
    {
        return $this->property;
    }

}