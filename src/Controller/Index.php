<?php

namespace Controller;

use Sawazon\Controller;
use Sawazon\DAO\DAO;
use Sawazon\DAO\DAOProvider;
use View\IndexTemplate;
use View\NavbarTemplate;

class Index implements Controller
{
    public function display()
    {
        $t = new NavbarTemplate();
        $t->addParam('content', new IndexTemplate());
        $t->render();
    }
}