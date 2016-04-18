<?php

namespace View\Product;

use Processing\Text\DefaultTextFilter;
use Processing\Text\TagsEmphasis;
use Routing\Route;
use Sawazon\DAO\DAOProvider;
use Util\Session;
use View\RatingTemplate;
use View\Template;


class ProductShow extends Template
{

    public function __construct($product)
    {
        parent::__construct('product/show');
        $reviews = $product->review_all;

        $review_items = array_map(function ($r) {
            $t = new Template('review/show');
            $t->addParam('username', $r->user->username);
            $t->addParam('date', $r->published_on);
            $t->addParam('content', $r->content);
            $t->addParam('rating', new RatingTemplate($r->rating));
            $img = Route::get('image')->generate(['content' => 'user', 'id' => $r->user_id]);
            $t->addParam('user-img', $img);
            $t->addParam('user_link', Route::get('user_show')->generate(['id' => $r->user_id]));
            return $t;
        }, $reviews);

        $imgsrc = Route::get('image')->generate(['content' => 'product', 'id' => $product->product_id]);

        $prices = DAOProvider::get()->getPricesFor($product->product_id, 1);
        $price = getPrice(element('price', $prices[0], 0));

        $name = $product->name;
        $description = $product->description;


        $description = DefaultTextFilter::getInstance()->apply($description);
        $description = (new TagsEmphasis())->apply($description);


        $review_cnt = count($reviews);
        $rating = intval(array_sum(array_map(function ($r) {
                return $r->rating;
            }, $reviews)) / $review_cnt);

        $this->addParam('img-link', $imgsrc);
        $this->addParam('price', $price);
        $this->addParam('name', $name);
        $this->addParam('description', $description);
        $this->addParam('number-reviews', nounsp('review', $review_cnt));
        $this->addParam('rating', new RatingTemplate($rating));
        $this->addParam('reviews', $review_items);
        $this->addParam('views', nounsp('view', $product->view_count));

        $this->addParam('graph', new ProductGraph($product->product_id));

        if ($product->allow_review) {
            $footer = $this->getFooter($product->product_id);
            $this->addParam('reviews_footer', $footer);
        }
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