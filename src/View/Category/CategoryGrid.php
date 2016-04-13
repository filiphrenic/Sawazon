<?php

namespace View\Category;

use Model\Category;
use View\Template;

class CategoryGrid extends Template
{
    public function __construct()
    {
        parent::__construct('category/grid');

        $categories = (new Category())->loadAll("ORDER BY name");
        $items = array_map(function ($c) {
            return new CategoryThumbnail($c);
        }, $categories);

        $this->addParam('items', $items);
    }
}