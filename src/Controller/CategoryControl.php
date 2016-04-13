<?php

namespace Controller;

use Dispatch\Dispatcher;
use Model\Category;
use Sawazon\Controller;
use View\Category\CategoryShow;
use View\NavbarTemplate;

class CategoryControl implements Controller
{
    public function display()
    {
        $r = Dispatcher::getInstance()->getRoute();
        $category_id = $r->getParam('id');

        $category = (new Category())->load($category_id);

        $t = new NavbarTemplate();
        $t->addParam('content', new CategoryShow($category));
        $t->render();
    }
}