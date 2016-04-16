<?php

namespace Controller;

use Sawazon\Controller;
use View\NavbarTemplate;
use View\User\AdminPage;

class Admin extends Controller
{
    public function display()
    {
        $t = new NavbarTemplate();
        $t->addParam('content', new AdminPage());
        $t->render();
    }
}