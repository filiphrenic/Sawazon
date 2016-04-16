<?php

namespace Controller;

use Dispatch\Dispatcher;
use Model\Category;
use Processing\Image\ImageUpload;
use Routing\Route;
use Sawazon\Controller;
use View\Category\CategoryShow;
use View\InfoTemplate;
use View\NavbarTemplate;

class CategoryControl extends Controller
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

    public function addCategory()
    {
        $params = cleanAll(
            ['name', 'description'],
            $_POST
        );

        $category = new Category();
        $category->name = $params['name'];
        $category->description = $params['description'];

        $category->save();

        if (!empty($_FILES)) {
            $error = ImageUpload::upload($_FILES['category_picture'], "category/$category->category_id");
            if ($error) {
                $category->delete();
                $t = new NavbarTemplate();
                $t->addParam('content', new InfoTemplate("Category", $error . " -> category picture"));
                $t->render();
                return;
            }
        }

        redirect(Route::get('category_show')->generate(['id' => $category->category_id]));
    }
}