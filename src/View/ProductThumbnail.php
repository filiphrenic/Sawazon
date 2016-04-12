<?php

namespace View;

use Model\Product;
use Processing\Currency\CurrencyConverterProvider;
use Routing\Route;
use Sawazon\DAO\DAOProvider;
use Util\Session;

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
        $price = element('price', $prices[0], 0);
        $currency = Session::get(Session::$CURRENCY, 'HRK');
        $cc = CurrencyConverterProvider::get();
        $converted_price = $cc->convert($price, 'HRK', $currency);

        $heading = $product->name;
        $description = shorten($product->description, 100);


        $reviews = $product->review_all;
        $review_cnt = count($reviews);

        $rating = intval(array_sum(array_map(function ($r) {
                return $r->rating;
            }, $reviews)) / $review_cnt);

        $this->addParam('img-link', $imgsrc);
        $this->addParam('link', $link);
        $this->addParam('price', "$converted_price $currency");
        $this->addParam('heading', $heading);
        $this->addParam('description', $description);
        $this->addParam('reviews', nounsp('review', $review_cnt));
        $this->addParam('rating', new RatingTemplate($rating));
    }
}