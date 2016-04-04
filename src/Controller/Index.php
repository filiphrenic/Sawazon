<?php

namespace Controller;

use Sawazon\Controller;
use View\DefaultTemplate;
use View\TestClass;

class Index implements Controller
{
    public function display()
    {
        $t = new DefaultTemplate('main');
        $t->render();
    }
}