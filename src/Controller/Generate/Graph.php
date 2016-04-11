<?php

namespace Controller\Generate;

use Sawazon\Controller;
use Sawazon\DAO\DAOProvider;

class Graph implements Controller
{

    public function category_json()
    {
        $category_id = 1;//cleanHTML(element('category_id', $_POST, ''));
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

}