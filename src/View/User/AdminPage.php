<?php

namespace View\User;

use Routing\Route;
use View\Template;

class AdminPage extends Template
{

    public function __construct()
    {
        parent::__construct('user/admin');

        $t = new Template('category/form');
        $t->addParam('form_link', Route::get('category_add')->generate());
        $this->addParam('category_form', $t);

        $t = new Template('user/admin_users');
        $this->addParam('users', $t);
    }


}