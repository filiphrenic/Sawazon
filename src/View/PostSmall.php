<?php

namespace View;

use Model\Post;
use Processing\Text\DefaultTextFilter;
use Processing\Text\TagsEmphasis;
use Routing\Route;

class PostSmall extends Template
{

    public function __construct($post_id)
    {
        parent::__construct('post/for_index');
        $post = (new Post())->load($post_id);
        $author = $post->user;
        $img = Route::get('image')->generate(['content' => 'user', 'id' => $author->user_id]);

        $user_link = Route::get('user_show')->generate(['id' => $author->user_id]);
        $this->addParam('user_link', $user_link);


        $content = $post->content; // :)
        $content = (new TagsEmphasis())->apply($content);
        $content = DefaultTextFilter::getInstance()->apply($content);


        $this->addParam('username', $author->username);
        $this->addParam('user-img', $img);
        $this->addParam('date', $post->published_on);
        $this->addParam('heading', $post->heading);
        $this->addParam('content', $content);
    }
}