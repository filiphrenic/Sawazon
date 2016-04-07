<?php

namespace Controller;

use Sawazon\Controller;
use View\CategoryShow;
use View\NavbarTemplate;

class CategoryControl implements Controller
{
    public function display(){

        $t = new NavbarTemplate();
        $t->addParam('content', new CategoryShow());
        $t->render();

    }
}