<?php

namespace View\Product;

use Routing\Route;
use View\Template;

class ProductGraph extends Template
{

    public function __construct($product_id)
    {
        parent::__construct('product/graph');
        $link = Route::get('product_report')->generate();
        $this->addParam('product_id', $product_id);
        $this->addParam('graph-link', $link);
    }
}
