<?php

namespace View\Product;

use Model\Product;
use Processing\Text\DefaultTextFilter;
use Processing\Text\TagsEmphasis;
use Routing\Route;
use Sawazon\DAO\DAOProvider;
use View\RatingTemplate;
use View\Template;

class ProductThumbnail extends Template
{
    /**
     * ProductThumbnail constructor.
     * @param Product $product
     */
    public function __construct($product)
    {
        parent::__construct('product/thumbnail');

        $imgsrc = Route::get('image')->generate(['content' => 'product', 'id' => $product->product_id]);
        $link = Route::get('product_show')->generate(['id' => $product->product_id]);

        $prices = DAOProvider::get()->getPricesFor($product->product_id, 1);
        $price = getPrice(element('price', $prices[0], 0));

        $heading = $product->name;
        $description = shorten($product->description, 100);

        $description = DefaultTextFilter::getInstance()->apply($description);
        $description = (new TagsEmphasis())->apply($description);

        $reviews = $product->review_all;
        $review_cnt = count($reviews);

        $rating = intval(array_sum(array_map(function ($r) {
                return $r->rating;
            }, $reviews)) / $review_cnt);

        $this->addParam('img-link', $imgsrc);
        $this->addParam('link', $link);
        $this->addParam('price', $price);
        $this->addParam('heading', $heading);
        $this->addParam('description', $description);
        $this->addParam('reviews', nounsp('review', $review_cnt));
        $this->addParam('rating', new RatingTemplate($rating));
    }
}