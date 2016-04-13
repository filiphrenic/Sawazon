<?php

namespace View\Category;

use Routing\Route;
use View\Template;

class CategoryGraph extends Template
{
    public function __construct($category_id)
    {
        parent::__construct('category/graph');
        $link = Route::get('category_report')->generate();
        $this->addParam('category_id', $category_id);
        $this->addParam('graph-link', $link);
    }
}