<?php

namespace DB;

use Model\Product;
use Sawazon\DAO\DAO;

class DBDAO implements DAO
{

    public function getMostViewedProducts($n = 5)
    {
        return (new Product())->loadAll("ORDER BY view_count DESC LIMIT $n");
    }

    public function getPricesFor($product_id, $numOfPrices)
    {
        $sql = "SELECT price, date_changed FROM ProductPrice WHERE product_id = ?"
            . " ORDER BY date_changed DESC LIMIT $numOfPrices";

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute([$product_id]);

        if(1>$statement->rowCount()) return [];
        else return $statement->fetch();
    }
}