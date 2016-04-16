<?php

namespace Controller;

use Model\Post;
use Model\User;
use Processing\Text\DefaultTextFilter;
use Routing\Route;
use Sawazon\Controller;
use View\InfoTemplate;
use View\NavbarTemplate;

class PostControl extends Controller
{

    public function newPost()
    {
        $params = cleanAll(
            ['user_id', 'heading', 'content'],
            $_POST
        );

        if (!User::exists('user_id', $params['user_id'])) {
            $t = new NavbarTemplate();
            $t->addParam('content', new InfoTemplate("Post", "User doesn't exist"));
            $t->render();
            return;
        }

        $post = new Post();
        $post->user_id = $params['user_id'];
        $post->heading = $params['heading'];
        $post->content = $params['content'];

        $post->save();

        redirect(Route::get('index')->generate());
    }
}
