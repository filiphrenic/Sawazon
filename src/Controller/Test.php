<?php

namespace Controller;

use Processing\Text\TagsEmphasis;
use Sawazon\Controller;
use View\NavbarTemplate;
use View\User\UserProfile;

class Test extends Controller
{
    public function test()
    {
        $t = new NavbarTemplate();
        $t->addParam('content', new UserProfile());
        $t->render();

    }
}