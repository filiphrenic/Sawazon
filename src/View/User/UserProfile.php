<?php

namespace View\User;

use View\PostSmall;
use View\Product\ProductSmall;
use View\Template;

class UserProfile extends Template
{
    public function __construct($user)
    {
        parent::__construct('user/profile');
        $this->addParam('user', $user);
        $this->addParam('country', $user->country->name);

        $products = [];
        foreach ($user->product_all as $p)
            $products[] = new ProductSmall($p->product_id);

        $posts = [];
        foreach ($user->post_all as $p)
            $posts[] = new PostSmall($p->post_id);

        $this->addParam('posts', $posts);
        $this->addParam('products', $products);
    }
}