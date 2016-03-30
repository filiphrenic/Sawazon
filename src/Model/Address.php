<?php

namespace Model;

use DB\DBModel;

class Address extends DBModel
{

    public function getColumnNames()
    {
        return ['address_id', 'user_id', 'street', 'city', 'country_id'];
    }


}