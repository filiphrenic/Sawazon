<?php

namespace View;

use Model\Post;
use Model\Product;
use Routing\Route;

class SearchResults extends Template
{

    public function __construct($words, $idsAndTypes)
    {
        parent::__construct('search_results');
        $this->addParam('title', $this->getTitle($words));
        $this->addParam('content', $this->getContent($idsAndTypes));
    }

    private function getTitle($words)
    {
        if (empty($words)) return "how??";
        $title = [];
        foreach ($words as $w) $title[] = "#$w";
        return implode(' ', $title);
    }

    private function getContent($idsAndTypes)
    {
        $content = [];

        foreach ($idsAndTypes as $m) {
            if ($m['type'] == 'POST') {
                $post = (new Post())->load($m['id']);
                $author = $post->user;
                $img = Route::get('image')->generate(['content' => 'user', 'id' => $author->user_id]);

                $t = new Template('post/for_index');
                $t->addParam('username', $author->first_name);
                $t->addParam('user-img', $img);
                $t->addParam('date', $post->published_on);
                $t->addParam('heading', $post->heading);
                $t->addParam('content', $post->content);

            } else { // product
                $product = (new Product())->load($m['id']);
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

            $content[] = $t;
        }
        return $content;
    }
}