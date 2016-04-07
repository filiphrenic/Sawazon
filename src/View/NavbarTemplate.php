<?php

namespace View;


use Model\Country;
use Routing\Route;

class NavbarTemplate extends Template
{

    public function __construct()
    {
        parent::__construct('main');

        if (null == user_id(null)) $navbar = $this->getNormalNavbar();
        else $navbar = $this->getLoggedInNavbar();

        $bg_color = element('bg_color', $_SESSION, "#FFFFFF");

        $this->addParam('bg_color', $bg_color);
        $this->addParam('navbar', $navbar);
    }

    /**
     * @return Template for visitor
     */
    private function getNormalNavbar()
    {
        $navbar = new Template('navbar/normal');

        $logreg = new Template('navbar/logreg');
        $logreg->addParam('log_link', Route::get('user_login')->generate());
        $logreg->addParam('reg_link', Route::get('user_register')->generate());
        $logreg->addParam('captcha_link', Route::get('captcha')->generate());
        $logreg->addParam('username_check_link', Route::get('username_check')->generate());
        $logreg->addParam('email_check_link', Route::get('email_check')->generate());

        $logreg->addParam('countries', (new Country())->loadAll());

        $navbar->addParam('logreg', $logreg);
        return $navbar;
    }

    /**
     * @return Template for logged in user
     */
    private function getLoggedInNavbar()
    {
        $navbar = new Template('navbar/logged_in');
        return $navbar;
    }

}