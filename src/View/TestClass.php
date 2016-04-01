<?php

namespace View;

class TestClass
{

    public $property = "mamica";

    public function __toString()
    {
        return 'to string funkcija';
    }

    public function testFunkcija()
    {
        return 'iz funkcije';
    }

}