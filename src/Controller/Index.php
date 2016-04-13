<?php

namespace Controller;

use Sawazon\Controller;
use View\IndexTemplate;
use View\NavbarTemplate;

class Index extends Controller
{
    public function display()
    {
        $t = new NavbarTemplate();
        $t->addParam('content', new IndexTemplate());
        $t->render();
    }
}