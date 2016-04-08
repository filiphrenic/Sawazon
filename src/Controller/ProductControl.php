<?php

namespace Controller;

use Sawazon\Controller;
use View\NavbarTemplate;
use View\ProductShow;

class ProductControl implements Controller
{
    public function display()
    {
        $t = new NavbarTemplate();
        $t->addParam('content', new ProductShow());
        $t->render();
    }
}