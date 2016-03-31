<?php

namespace Controller;

use Model\Address;
use Model\User;
use Routing\Route;
use Sawazon\Controller;

class Index implements Controller
{
    public function display()
    {

        $img = Route::get("image")->generate(['content' => 'user', 'id' => '1']);

//        echo "
//        <!doctype html>
//        <html>
//            <head>
//            <title>TAJTL</title>
//            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
//            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
//            <meta name=\"description\" content=\"Sawazon\">
//            <meta name=\"author\" content=\"Filip Hrenić, filip.hrenic@fer.hr\">
//            <script src=\"/web/js/test.js\"></script>
//            </head>
//            <body>
//                <img src=\"$img\">
//            </body>
//        </html>
//        ";

        $u = (new User())->loadAll("WHERE user_id = ?", [1]);
        var_dump($u);

    }
}