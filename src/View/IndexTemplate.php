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
        $this->addParam('content', $content);
    }

    private function contentFor($user_id)
    {
        $content = DAOProvider::get()->getRecentContentForUser($user_id, 10, 10);

        $t = new Template('post/form');
        $img = Route::get('image')->generate(['content'=>'user', 'id'=>$user_id]);
        $t->addParam('user_id', $user_id);
        $t->addParam('form-link', Route::get('post_save')->generate());
        $t->addParam('usr-img', $img);

        $ret = [$t];

        foreach ($content as $c){
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
                $t->addParam('price', getPrice($product->getLastPrice()));

                $plink = Route::get('product_show')->generate(['id' => $product->product_id]);

                $t->addParam('pname', $product->name);
                $t->addParam('plink', $plink);
            }

            $ret[] = $t;
        }

        return $ret;
    }

    private function contentForVisitor()
    {
        return new CategoryGrid();
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