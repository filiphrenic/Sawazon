<?php

namespace Controller;

use Sawazon\Controller;

class Test extends Controller
{
    public function test()
    {
        $x = "#xxx yolo mama #aaa200 asd #aAAa.. $";
//        $x = "";

        $pattern = "%(?P<word>[\\w\\d]+)%u";
        
        preg_match_all($pattern, $x, $matches);
        echoJson($matches);
    }
}