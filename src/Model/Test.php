<?php

namespace Model;

use DB\DBModel;

class Test extends DBModel
{
    public function getTableName()
    {
        return 'Test';
    }

    public function getPrimaryKeyColumn()
    {
        return 'id';
    }

    public function getColumnNames()
    {
        return ['id', 'name', 'lol'];
    }

}