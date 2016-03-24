<?php

namespace DB;

use PDO;
use PDOException;

class DB
{

    /**
     * @var PDO
     */
    private static $pdo;

    /**
     * @return PDO
     */
    public static function getPDO()
    {

        if (null === self::$pdo) {
            try {
                self::$pdo = new PDO(
                    "mysql:dbname=Sawazon", "root", "root", array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    )
                );
            } catch (PDOException $e) {
                var_dump($e);
                die();
            }
        }

        return self::$pdo;
    }

}
