<?php

namespace View\User;

use Routing\Route;
use View\Template;

class AdminPage extends Template
{

    public function __construct()
    {
        parent::__construct('user/admin');
        $this->addParam('category_form', $this->getCategoryForm());
    }

    private function getCategoryForm()
    {
        $t = new Template('category/form');
        $t->addParam('form_link', Route::get('category_add')->generate());
        return $t;
    }

}