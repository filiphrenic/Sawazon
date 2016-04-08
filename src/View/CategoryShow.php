<?php

namespace View;

use Dispatch\Dispatcher;
use Model\Category;
use Routing\Route;

class CategoryShow extends Template
{

    public function __construct()
    {
        parent::__construct('category/show');
        
        $categories = (new Category())->loadAll("ORDER BY name DESC");

        $category_items = array_map(function ($c) {
            $t = new Template('category/list_item');
            $link = Route::get('category_show')->generate(['id' => $c->category_id]);
            $t->addParam('link', $link);
            $t->addParam('name', $c->name);
            return $t;
        }, $categories);


        $r = Dispatcher::getInstance()->getRoute();
        $category_id = $r->getParam('id');

        $category = (new Category())->load($category_id);
        $products = $category->product_all;

        $items = array_map(function ($p) {
            return new ProductThumbnail($p);
        }, $products);

        $this->addParam('category_items', $category_items);
        $this->addParam('items', $items);

    }
}