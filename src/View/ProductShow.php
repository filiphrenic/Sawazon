<?php

namespace View;

use Dispatch\Dispatcher;
use Model\Product;
use Processing\Currency\CurrencyConverterProvider;
use Routing\Route;
use Sawazon\DAO\DAOProvider;
use Util\Session;


class ProductShow extends Template
{

    public function __construct()
    {
        parent::__construct('product/show');

        $r = Dispatcher::getInstance()->getRoute();
        $product_id = $r->getParam('id');

        $product = (new Product())->load($product_id);
        $reviews = $product->review_all;

        $review_items = array_map(function ($r) {
            $t = new Template('review/show');
            $t->addParam('username', $r->user->username);
            $t->addParam('date', $r->published_on);
            $t->addParam('content', $r->content);
            $t->addParam('rating', new RatingTemplate($r->rating));
            $img = Route::get('image')->generate(['content' => 'user', 'id' => $r->user_id]);
            $t->addParam('user-img', $img);
            return $t;
        }, $reviews);

        $imgsrc = Route::get('image')->generate(['content' => 'product', 'id' => $product->product_id]);

        $price = DAOProvider::get()->getPricesFor($product->product_id, 1);
        $price = element('price', $price, 0);
        $currency = Session::get(Session::$CURRENCY, 'HRK');
        $cc = CurrencyConverterProvider::get();
        $converted_price = $cc->convert($price, 'HRK', $currency);

        $name = $product->name;
        $description = $product->description;

        $review_cnt = count($reviews);
        $rating = intval(array_sum(array_map(function ($r) {
                return $r->rating;
            }, $reviews)) / $review_cnt);

        $this->addParam('img-link', $imgsrc);
        $this->addParam('price', "$converted_price $currency");
        $this->addParam('name', $name);
        $this->addParam('description', $description);
        $this->addParam('number-reviews', nounsp('review', $review_cnt));
        $this->addParam('rating', new RatingTemplate($rating));
        $this->addParam('stars', nounsp('star', $rating));
        $this->addParam('reviews', $review_items);

        $footer = $this->getFooter($product_id);
        $this->addParam('reviews_footer', $footer);
    }

    private function getFooter($product_id)
    {

        if (($user_id = Session::get(Session::$USER_ID, null)) != null) {
            $imgsrc = Route::get('image')->generate(['content' => 'user', 'id' => $user_id]);
            $link = Route::get('review_add')->generate();

            $t = new Template('review/user_form');
            $t->addParam('user-img', $imgsrc);
            $t->addParam('review_submit', $link);
            $t->addParam('user_id', $user_id);
            $t->addParam('product_id', $product_id);
            return $t;
        } else {
            return new Template('review/visitor_button');
        }
    }
}