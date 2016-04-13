<?php

namespace Model;

use DB\DBModel;

class Country extends DBModel
{

    public function getColumnNames()
    {
        return ['country_id', 'name', 'code'];
    }


}