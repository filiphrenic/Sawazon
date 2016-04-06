<?php

namespace Controller;

use Sawazon\Controller;
use View\DefaultTemplate;

class Index implements Controller
{
    public function display()
    {
        $t = new DefaultTemplate();
        $t->render();
    }
}