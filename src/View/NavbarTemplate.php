<?php

namespace View;


use Model\Category;
use Model\Country;
use Routing\Route;
use Util\Session;

class NavbarTemplate extends Template
{

    public function __construct()
    {
        parent::__construct('main');

        if (null == Session::get(Session::$USER_ID))
            $navbar = $this->getNormalNavbar();
        else $navbar = $this->getLoggedInNavbar();

        $bg_color = Session::get(Session::$BG_COLOR, '#f5f5f5');

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
        $logreg->addParam('categories', (new Category())->loadAll());

        $navbar->addParam('home', Route::get('index')->generate());
        $navbar->addParam('logreg', $logreg);

        return $navbar;
    }

    /**
     * @return Template for logged in user
     */
    private function getLoggedInNavbar()
    {
        return $this->getNormalNavbar();
//        $navbar = new Template('navbar/logged_in');
//        return $navbar;
    }

}