<?php

namespace View;

use Sawazon\DAO\DAOProvider;

class IndexTemplate extends Template
{

    public function __construct()
    {
        parent::__construct('index');
        $carousel = $this->createCarousel(5);
        $category_grid = new CategoryGrid();
        $this->addParam('product_carousel', $carousel);
        $this->addParam('category_grid', $category_grid);
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