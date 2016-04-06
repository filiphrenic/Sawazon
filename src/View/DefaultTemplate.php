<?php

namespace View;


use Model\Country;
use Routing\Route;

class DefaultTemplate extends Template
{

    public function __construct()
    {
        parent::__construct('main');


        if (null == user_id(null)) $navbar = $this->getNormalNavbar();
        else $navbar = $this->getLoggedInNavbar();

        $ses = '';
        print_r($_SESSION, $ses);
        $navbar->addParam('session', $ses);

        $this->addParam('navbar', $navbar);
    }

    /**
     * @return Template for visitor
     */
    private function getNormalNavbar()
    {
        $navbar = new Template('navbar/normal');

        $logreg = new Template('navbar/logreg');
        $logreg->addParam('log-link', Route::get('user_login')->generate());
        $logreg->addParam('reg-link', Route::get('user_register')->generate());
        $logreg->addParam('captcha-link', Route::get('captcha')->generate());

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