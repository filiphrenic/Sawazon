<?php

namespace Controller;

use Dispatch\Dispatcher;
use Model\Product;
use Sawazon\Controller;
use View\NavbarTemplate;
use View\Product\ProductShow;

class ProductControl implements Controller
{
    public function display()
    {
        $r = Dispatcher::getInstance()->getRoute();
        $product_id = $r->getParam('id');
        $product = (new Product())->load($product_id);

        $t = new NavbarTemplate();
        $t->addParam('content', new ProductShow($product));
        $t->render();
    }
}