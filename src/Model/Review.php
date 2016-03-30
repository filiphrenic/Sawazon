<?php

namespace Model;

use DB\DBModel;

class Review extends DBModel
{
    public function getColumnNames()
    {
        return ['review_id', 'product_id', 'user_id', 'content', 'rating', 'date_reviewed'];
    }
}