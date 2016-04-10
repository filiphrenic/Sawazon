<?php

namespace View;

use Routing\Route;
use Util\Session;

class InfoTemplate extends Template
{
    public function __construct($heading, $description)
    {
        parent::__construct('info');
        $this->addParam('heading', $heading);
        $this->addParam('description', $description);
        $this->addParam('back-page', Session::get(Session::$LAST_URL));
        $this->addParam('home-page',Route::get('index')->generate());
    }
}