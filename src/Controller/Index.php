<?php

namespace Controller;

use Sawazon\Controller;
use View\DefaultTemplate;

class Index implements Controller
{
    public function display()
    {
//        unset($_SESSION['user_id']);
        $t = new DefaultTemplate();
        $t->render();
    }
}