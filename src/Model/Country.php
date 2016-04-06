<?php

namespace Model;

use DB\DBModel;

class Country extends DBModel
{

    public function getColumnNames()
    {
        return ['country_id', 'name', 'code'];
    }

    public function toOption()
    {
        return "<option value=\"$this->country_id\">$this->name</option>";
    }


}