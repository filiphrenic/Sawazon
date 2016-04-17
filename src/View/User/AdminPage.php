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
        $t->addParam('usernames_link', Route::get('all_usernames')->generate());
        $t->addParam('users_action_link', Route::get('users_action')->generate());
        $this->addParam('users', $t);
    }


}