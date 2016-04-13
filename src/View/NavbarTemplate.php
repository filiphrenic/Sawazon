<?php

namespace View;


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

        $navbar->addParam('home', Route::get('index')->generate());

        $bg_color = Session::get(Session::$BG_COLOR, '#ffffff');

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


        $country_opts = array_map(
            function ($c) {
                return "<option value='$c->country_id'>$c->name</option>";
            },
            (new Country())->loadAll()
        );
        $logreg->addParam('country_opts', $country_opts);

        $navbar->addParam('logreg', $logreg);

        return $navbar;
    }

    /**
     * @return Template for logged in user
     */
    private function getLoggedInNavbar()
    {
        $navbar = new Template('navbar/logged_in');
        $link = Route::get('user_logout')->generate();
        $plink = Route::get('product_add')->generate();
        $navbar->addParam('logout-link', $link);
        $navbar->addParam('product_add_link', $plink);
        return $navbar;
    }

}