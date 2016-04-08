<?php

namespace View;

use Routing\Route;
use Util\Session;

class ErrorTemplate extends Template
{
    public function __construct($code, $description)
    {
        parent::__construct('error');
        $this->addParam('code', $code);
        $this->addParam('description', $description);
        $this->addParam('back-page', Session::get(Session::$LAST_URL));
        $this->addParam('home-page',Route::get('index')->generate());
    }
}