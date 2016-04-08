<?php

namespace Controller;

use Model\Review;
use Sawazon\Controller;

class ReviewControl implements Controller
{
    public function addReview()
    {

        $params = cleanAll(['user_id', 'product_id', 'rating', 'content'], $_POST);

        $user_id = $params['user_id'];
        $product_id = $params['product_id'];
        $rating = $params['rating'];
        $content = $params['content'];
        
        if (!preg_match('%^\\d$%', $rating)) $rating = '5';

        if (!empty($user_id) && !empty($product_id)) {
            $r = new Review();
            $r->product_id = $product_id;
            $r->user_id = $user_id;
            $r->content = $content;
            $r->rating = $rating;
            $r->save();
        }

        redirectToLast();
    }
}