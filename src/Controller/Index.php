<?php

namespace Controller;

use Sawazon\Controller;
use View\Templater;
use View\TestClass;

class Index implements Controller
{
    public function display()
    {

        $t = new Templater('proba');
        $t->addParam('test',new TestClass(42));
        $t->render();

        //$img = Route::get("image")->generate(['content' => 'user', 'id' => '1']);

//        echo "
//        <!doctype html>
//        <html>
//            <head>
//            <title>TAJTL</title>
//            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
//            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
//            <meta name=\"description\" content=\"Sawazon\">
//            <meta name=\"author\" content=\"Filip Hrenić, filip.hrenic@fer.hr\">
//        <link rel="alternate"
//type="application/rss+xml" title="NASLOV"
//href="ADRESA">
//            <script src=\"/web/js/test.js\"></script>
//            </head>
//            <body>
//                <img src=\"$img\">
//            </body>
//        </html>
//        ";

//        $im = element('image', $_FILES, null);
//        if ($im !== null) {
//            var_dump(ImageUpload::upload($im, 'user/4'));
//        }
//
//        echo "<form action=\"/\" method=\"post\" enctype=\"multipart/form-data\">
//    <input type='file' name='image'>
//  <input type=\"submit\" value=\"Submit\">
//</form>";


    }
}