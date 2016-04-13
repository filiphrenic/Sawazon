<?php

namespace View\User;

use Routing\Route;
use Util\Session;
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
        $this->addParam('user_image',
            Route::get('image')->generate(['content' => 'user', 'id' => $user->user_id])
        );

        $products = [];
        foreach ($user->product_all as $p)
            $products[] = new ProductSmall($p->product_id);

        $posts = [];
        foreach ($user->post_all as $p)
            $posts[] = new PostSmall($p->post_id);

        $this->addParam('posts', $posts);
        $this->addParam('products', $products);

        $user_id = Session::get(Session::$USER_ID, null);
        $can_follow = $user_id != null && $user_id != $user->user_id;
        $this->addParam('can_follow', $can_follow);

        if (!$can_follow) $user_id = '';
        $this->addParam('user_id', $user_id);
        $this->addParam('follow_check', Route::get('follow_check')->generate());
        $this->addParam('follow_modify', Route::get('follow_modify')->generate());

    }
}