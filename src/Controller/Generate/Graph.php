<?php

namespace Controller\Generate;

use Sawazon\Controller;
use Sawazon\DAO\DAOProvider;

class Graph extends Controller
{

    public function category_json()
    {
        $category_id = cleanHTML(element('category_id', $_POST, ''));
        $numOfProducts = 5; // hardcoded hehe

        $expensive = DAOProvider::get()->getProductNamesAndPrices(
            $category_id,
            $numOfProducts,
            true
        );

        $cheap = DAOProvider::get()->getProductNamesAndPrices(
            $category_id,
            $numOfProducts,
            false
        );

        $data = [
            'expensive' => $expensive,
            'cheap' => $cheap
        ];

        echoJson($data);
    }

    public function product_json()
    {
        $product_id = cleanHTML(element('product_id', $_POST, ''));
        $data = DAOProvider::get()->getPricesFor($product_id, null);
        echoJson($data);
    }

}