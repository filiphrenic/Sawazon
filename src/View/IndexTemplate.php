<?php

namespace View;

use Routing\Route;
use Sawazon\DAO\DAOProvider;
use Util\Session;
use View\Category\CategoryGrid;
use View\Product\ProductCarouselItem;
use View\Product\ProductSmall;

class IndexTemplate extends Template
{

    public function __construct()
    {
        parent::__construct('index');
        if (($user_id = Session::get(Session::$USER_ID)) != null)
            $this->addParam('content', $this->contentFor($user_id));
        $this->addParam('product_carousel', $this->createCarousel(5));
        $this->addParam('category_grid', new CategoryGrid());

    }

    private function contentFor($user_id)
    {
        $content = DAOProvider::get()->getRecentContentForUser($user_id, 10, 10);

        $t = new Template('post/form');
        $img = Route::get('image')->generate(['content' => 'user', 'id' => $user_id]);
        $t->addParam('user_id', $user_id);
        $t->addParam('form-link', Route::get('post_save')->generate());
        $t->addParam('usr-img', $img);

        $ret = [$t];

        foreach ($content as $c) {
            if ($c['type'] == 'post')
                $t = new PostSmall($c['id']);
            else if ($c['type'] == 'product')
                $t = new ProductSmall($c['id']);
            $ret[] = $t;
        }

        return $ret;
    }

    private function createCarousel($n)
    {
        $items = [];
        $most_viewed_products = DAOProvider::get()->getMostViewedProducts($n);
        $n = count($most_viewed_products);

        for ($idx = 0; $idx < $n; $idx++)
            $items[] = new ProductCarouselItem($most_viewed_products[$idx], $idx);

        $carousel = new Template('product_carousel');
        $carousel->addParam('items', $items);
        return $carousel;
    }

}