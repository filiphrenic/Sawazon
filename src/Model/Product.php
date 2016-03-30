<?php

namespace Model;

use DB\DBModel;

class Product extends DBModel
{

    public function getColumnNames()
    {
        return ['product_id', 'user_id', 'category_id', 'name', 'description',
            'allow_review', 'published_on', 'view_count'];
    }

}