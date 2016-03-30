<?php

namespace Model;


use DB\DBModel;

class Category extends DBModel
{

    public function getColumnNames()
    {
        return ['category_id', 'name', 'description'];
    }

}