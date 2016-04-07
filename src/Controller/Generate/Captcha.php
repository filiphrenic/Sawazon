<?php

namespace Controller\Generate;

use Generate\CaptchaMaker;
use Sawazon\Controller;
use Util\Session;

class Captcha implements Controller
{
    
    public function display()
    {
        $captcha = new CaptchaMaker();
        Session::set(Session::$CAPTCHA, $captcha->getText());
        header("Content-Type: image/png");
        imagepng($captcha->getImage());
        imagedestroy($captcha->getImage());
    }

}