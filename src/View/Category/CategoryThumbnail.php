<?php

namespace View\Category;

use Model\Category;
use Routing\Route;
use View\Template;

class CategoryThumbnail extends Template
{

    /**
     * CategoryThumbnail constructor.
     * @param Category $category
     */
    public function __construct($category)
    {
        parent::__construct('category/thumbnail');

        $imgsrc = Route::get('image')->generate(['content' => 'category', 'id' => $category->category_id]);
        $link = Route::get('category_show')->generate(['id' => $category->category_id]);
        $heading = $category->name;
        $description = $category->description;

        $this->addParam('link', $link);
        $this->addParam('img-link', $imgsrc);
        $this->addParam('heading', $heading);
        $this->addParam('description', $description);
    }

}