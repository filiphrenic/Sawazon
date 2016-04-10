<?php

namespace Controller;

use Dispatch\Dispatcher;
use Sawazon\Controller;
use View\InfoTemplate;
use View\NavbarTemplate;

class Info implements Controller
{
    public function error()
    {
        $code = Dispatcher::getInstance()->getRoute()->getParam('code');

        switch ($code) {
            case '404':
                $description = "Page not found";
                break;
            case '500':
            default:
                $description = "Server side error";
        }

        $t = new NavbarTemplate();
        $t->addParam('content', new InfoTemplate($code, $description));
        $t->render();
    }

}