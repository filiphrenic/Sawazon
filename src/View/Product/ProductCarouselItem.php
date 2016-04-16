<?php

namespace View\Product;

use Model\Product;
use Processing\Text\DefaultTextFilter;
use Processing\Text\TagsEmphasis;
use Routing\Route;
use View\Template;

class ProductCarouselItem extends Template
{

    /** @var  int */
    private $idx;

    /**
     * ProductCarousel constructor.
     * @param Product $product
     * @param int $idx
     */
    public function __construct($product, $idx)
    {
        parent::__construct('product/carousel_item');

        $this->idx = $idx;

        $class = "item" . ($idx == 0 ? " active" : "");
        $imgsrc = Route::get('image')->generate(['content' => 'product', 'id' => $product->product_id]);
        $link = Route::get('product_show')->generate(['id' => $product->product_id]);
        $heading = $product->name;
        $description = $product->description;

        $description = DefaultTextFilter::getInstance()->apply($description);
        $description = (new TagsEmphasis())->apply($description);

        $this->addParam('class', $class);
        $this->addParam('img-link', $imgsrc);
        $this->addParam('link', $link);
        $this->addParam('heading', $heading);
        $this->addParam('description', $description);
    }

    public function getIndicator()
    {
        $class = $this->idx == 0 ? "class=\"active\"" : "";
        return "<li data-target=\"#product_carousel\" data-slide-to=\"$this->idx\" $class></li>";
    }

}