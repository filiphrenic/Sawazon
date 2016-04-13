<?php

namespace View;

use Model\Post;
use Routing\Route;

class PostSmall extends Template
{

    public function __construct($post_id)
    {
        parent::__construct('post/for_index');
        $post = (new Post())->load($post_id);
        $author = $post->user;
        $img = Route::get('image')->generate(['content' => 'user', 'id' => $author->user_id]);

        $this->addParam('username', $author->first_name);
        $this->addParam('user-img', $img);
        $this->addParam('date', $post->published_on);
        $this->addParam('heading', $post->heading);
        $this->addParam('content', $post->content);
    }
}