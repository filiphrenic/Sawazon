<?php

namespace Controller\Generate;

use Generate\CaptchaMaker;
use Sawazon\Controller;

class Captcha implements Controller
{


    public function display()
    {
        $captcha = new CaptchaMaker();
        $_SESSION['captcha'] = $captcha->getText();
        header("Content-Type: image/png");
        imagepng($captcha->getImage());
        imagedestroy($captcha->getImage());
    }

}