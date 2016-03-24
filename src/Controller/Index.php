<?php

namespace Controller;

use Model\Test;
use Sawazon\Controller;

class Index extends Controller
{
    public
    function display()
    {
//        echo 'bok iz controllera<br>';
//        echo DefaultTextFilter::getInstance()->apply(" **Filip :)** bla bla **foo bar **");

        //echo 'index';
        $t = new Test();
        $t->get(1);

    }
}