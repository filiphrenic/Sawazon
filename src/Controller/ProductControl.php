<?php

namespace Controller;

use Dispatch\Dispatcher;
use Model\Category;
use Model\Product;
use Model\User;
use Processing\Image\ImageUpload;
use Routing\Route;
use Sawazon\Controller;
use View\InfoTemplate;
use View\NavbarTemplate;
use View\Product\ProductForm;
use View\Product\ProductShow;

class ProductControl extends Controller
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

    public function showForm()
    {
        $t = new NavbarTemplate();
        $t->addParam('content', new ProductForm());
        $t->render();
    }

    public function newProduct()
    {
        $params = cleanAll(
            ['category_id', 'user_id', 'name', 'description', 'allow_review'],
            $_POST
        );

        $registerError = function ($description) {
            $t = new NavbarTemplate();
            $t->addParam('content', new InfoTemplate("Product", $description));
            $t->render();
        };

        if (!Category::exists('category_id', $params['category_id'])) {
            $registerError("Category doesn't exist");
            return;
        }

        if (!User::exists('user_id', $params['user_id'])) {
            $registerError("User doesn't exist");
            return;
        }

        $product = new Product();
        $product->category_id = $params['category_id'];
        $product->user_id = $params['user_id'];
        $product->name = $params['name'];
        $product->description = $params['description'];
        $product->allow_review = $params['allow_review'] == '0' ? '0' : '1';

        $product->save();

        if (!empty($_FILES)) {
            $error = ImageUpload::upload($_FILES['product_picture'], "product/$product->product_id");
            if ($error) {
                $product->delete();
                $registerError($error . " -> product picture");
                return;
            }
        }

        redirect(Route::get('product_show')->generate(['id' => $product->product_id]));
    }
}