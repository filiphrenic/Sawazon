<?php

namespace Controller;

use Routing\Route;
use Sawazon\Controller;

class Index extends Controller
{
    public function display()
    {
        $src = Route::get("image")->generate(['content' => 'user', 'id' => '1']);
        echo "<img src='" . $src . "'>'";
        
        echo '<h1>bok</h1>';
    }
}