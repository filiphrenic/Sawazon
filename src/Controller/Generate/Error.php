<?php

namespace Controller\Generate;

use Dispatch\Dispatcher;
use Sawazon\Controller;
use View\ErrorTemplate;
use View\NavbarTemplate;

class Error implements Controller
{
    public function display()
    {
        $code = Dispatcher::getInstance()->getRoute()->getParam('code');
        $description = $code == '404' ? "Page not found" : "Server side error";
        $t = new NavbarTemplate();
        $t->addParam('content', new ErrorTemplate($code, $description));
        $t->render();
    }
}