<?php

namespace Sawazon\DAO;

use DB\DBDAO;

class DAOProvider
{
    /** @var  DAO */
    private static $dao;

    public static function get()
    {
        if (self::$dao == null)
            self::$dao = new DBDAO();
        return self::$dao;
    }
}