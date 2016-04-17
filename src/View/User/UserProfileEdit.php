<?php

namespace View\User;

use Model\Country;
use Routing\Route;
use View\Template;

class UserProfileEdit extends Template
{
    public function __construct($user)
    {
        parent::__construct('user/edit');
        $this->addParam('user', $user);
        $this->addParam('usr_img', Route::get('image')->generate(['content' => 'user', 'id' => '1']));
        $this->addParam('edit_save_link', Route::get('edit_profile_save')->generate());

        $country_opts = array_map(
            function ($c) {
                return "<option value='$c->country_id'>$c->name</option>";
            },
            (new Country())->loadAll()
        );
        $this->addParam('country_opts', $country_opts);
        $this->addParam('change_pswd_link', Route::get('edit_profile_pswd')->generate());

        $this->addParam('country_name', (new Country())->load($user->country_id)->name);

    }
}