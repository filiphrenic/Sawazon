<?php

namespace Model;

use DB\DBModel;

class Post extends DBModel
{

    public function getColumnNames()
    {
        return ['post_id', 'user_id', 'heading', 'content', 'published_on'];
    }
}