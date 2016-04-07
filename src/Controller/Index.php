<?php

namespace Controller;

use Sawazon\Controller;
use View\IndexTemplate;
use View\NavbarTemplate;

class Index implements Controller
{
    public function display()
    {
//        unset($_SESSION['user_id']);
        $t = new NavbarTemplate();
        $t->addParam('content', new IndexTemplate());
        $t->render();
    }
}