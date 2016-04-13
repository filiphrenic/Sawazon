<?php

namespace View;

use Model\Post;
use Model\Product;
use Routing\Route;
use Sawazon\DAO\DAOProvider;
use Util\Session;
use View\Category\CategoryGrid;
use View\Product\ProductCarouselItem;

class IndexTemplate extends Template
{

    public function __construct()
    {
        parent::__construct('index');
        $carousel = $this->createCarousel(5);
        $this->addParam('product_carousel', $carousel);
        if (($user_id = Session::get(Session::$USER_ID)) != null)
            $content = $this->contentFor($user_id);
        else
            $content = $this->contentForVisitor();
        $this->addParam('content', $content); // array
    }

    private function contentFor($user_id)
    {
        $content = DAOProvider::get()->getRecentContentForUser($user_id, 10, 10);

        return array_map(
            function ($c) {

                if ($c['type'] == 'post') {
                    $post = (new Post())->load($c['id']);
                    $author = $post->user;
                    $img = Route::get('image')->generate(['content' => 'user', 'id' => $author->user_id]);

                    $t = new Template('post/for_index');
                    $t->addParam('username', $author->first_name);
                    $t->addParam('user-img', $img);
                    $t->addParam('date', $post->published_on);
                    $t->addParam('heading', $post->heading);
                    $t->addParam('content', $post->content);

                } else { // product
                    $product = (new Product())->load($c['id']);
                    $author = $product->user;
                    $img = Route::get('image')->generate(['content' => 'product', 'id' => $product->product_id]);

                    $t = new Template('product/for_index');
                    $t->addParam('username', $author->first_name);
                    $t->addParam('user-img', $img);
                    $t->addParam('date', $product->published_on);
                    $t->addParam('heading', $product->name);
                    $t->addParam('content', $product->description);

                    $plink = Route::get('product_show')->generate(['id' => $product->product_id]);

                    $t->addParam('pname', $product->name);
                    $t->addParam('plink', $plink);
                }

                return $t;
            },
            $content
        );
    }

    private function contentForVisitor()
    {
        return [new CategoryGrid()];
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