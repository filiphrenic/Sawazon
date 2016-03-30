<?php

namespace Model;

use DB\DBModel;

class User extends DBModel
{

    public function getColumnNames()
    {
        return ['user_id', 'username', 'password', 'first_name', 'last_name',
            'email', 'telephone', 'date_of_birth', 'user_role', 'background_color'];
    }


}