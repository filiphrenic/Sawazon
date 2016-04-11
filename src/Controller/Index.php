<?php

namespace Controller;

use Sawazon\Controller;
use View\CategoryGraph;
use View\NavbarTemplate;

class Index implements Controller
{
    public function display()
    {
        $t = new NavbarTemplate();
//        $t->addParam('content', new IndexTemplate());
        $t->addParam('content', new CategoryGraph());
        $t->render();

//        var_dump(DAOProvider::get()->getProductNamesAndPrices(1, 5, true));

    }
}