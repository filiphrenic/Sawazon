<?php

namespace View\Category;

use Model\Category;
use Routing\Route;
use View\Product\ProductThumbnail;
use View\Template;

class CategoryShow extends Template
{

    public function __construct($category)
    {
        parent::__construct('category/show');

        $categories = (new Category())->loadAll("ORDER BY name ASC");

        $category_items = array_map(function ($c) {
            $t = new Template('category/list_item');
            $link = Route::get('category_show')->generate(['id' => $c->category_id]);
            $t->addParam('link', $link);
            $t->addParam('name', $c->name);
            return $t;
        }, $categories);

        $products = $category->product_all;

        $items = array_map(function ($p) {
            return new ProductThumbnail($p);
        }, $products);

        $this->addParam('category_items', $category_items);
        $this->addParam('items', $items);
        $this->addParam('graph', new CategoryGraph($category->category_id));

    }
}