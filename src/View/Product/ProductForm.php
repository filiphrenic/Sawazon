<?php

namespace View\Product;

use Model\Category;
use Routing\Route;
use Util\Session;
use View\Template;

class ProductForm extends Template
{
    public function __construct()
    {
        parent::__construct('product/form');

        $categories = (new Category())->loadAll();
        $categ_opts = array_map(
            function ($c) {
                return "<option value='$c->category_id'>$c->name</option>";
            },
            $categories
        );

        $this->addParam('categ_opts', $categ_opts);
        $this->addParam('form_link', Route::get('product_save')->generate());
        $this->addParam('user_id', Session::get(Session::$USER_ID, ''));
        $this->addParam('currency', Session::get(Session::$CURRENCY, 'HRK'));
    }
}