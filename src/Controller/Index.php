<?php

namespace Controller;

use Processing\Text\DefaultTextFilter;

class Index
{
    public function display()
    {
        echo 'bok iz controllera<br>';

        echo DefaultTextFilter::getInstance()->apply(" **Filip :)** bla bla **foo bar **");

    }
}