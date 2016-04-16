<?php

namespace View;


use Model\Country;
use Model\User;
use Processing\Currency\CurrencyConverterProvider;
use Routing\Route;
use Util\Session;

class NavbarTemplate extends Template
{

    public function __construct()
    {
        parent::__construct('main');

        if (null == ($user_id = Session::get(Session::$USER_ID)))
            $navbar = $this->getNormalNavbar();
        else $navbar = $this->getLoggedInNavbar($user_id);

        $search = new Template('navbar/search');
        $search->addParam('search_link', Route::get('search')->generate());
        $navbar->addParam('search', $search);

        $left = new Template('navbar/left');
        $left->addParam('home', Route::get('index')->generate());
        $navbar->addParam('left', $left);

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
    private function getLoggedInNavbar($user_id)
    {
        $navbar = new Template('navbar/logged_in');
        $link = Route::get('user_logout')->generate();
        $plink = Route::get('product_add')->generate();
        $user = (new User())->load($user_id);

        $navbar->addParam('logout-link', $link);
        $navbar->addParam('product_add_link', $plink);
        $navbar->addParam('username', $user->username);
        $navbar->addParam('user-link', Route::get('user_show')->generate(['id' => $user_id]));

        $currencies = [];
        foreach (CurrencyConverterProvider::get()->getValidCurrencies() as $c) {
            $currencies[] = "<li><a href='' onclick=\"changeCurrency('$c');\">$c</a></li>";
        }
        $navbar->addParam('currencies', $currencies);
        $navbar->addParam('currency_change_link', Route::get('change_currency')->generate());
        $navbar->addParam('bgcolor_change_link', Route::get('change_bgcolor')->generate());
        return $navbar;
    }

}