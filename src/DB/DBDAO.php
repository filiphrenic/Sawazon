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

        if (1 > $statement->rowCount()) return [];
        else return $statement->fetch();
    }

    public function getCategoriesFor($user_id)
    {
        $sql = "SELECT category_id FROM UserCategory WHERE user_id = ?";

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute([$user_id]);

        if (1 > $statement->rowCount()) return [];
        else return $statement->fetch();
    }

    public function saveCategoriesFor($user_id, $categories)
    {
        $sql = "INSERT IGNORE INTO UserCategory (user_id, category_id) VALUES "
            . implode(
                ", ",
                array_map(
                    function ($c) use ($user_id) {
                        return "($user_id, ?)";
                    }, $categories)
            );
        DB::getPDO()->prepare($sql)->execute($categories);
    }

}