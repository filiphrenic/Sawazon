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

    public function getPricesFor($product_id, $numOfPrices = null)
    {
        $sql = "SELECT price, date_changed FROM ProductPrice WHERE product_id = ?"
            . " ORDER BY date_changed DESC";
        if ($numOfPrices != null)
            $sql .= " LIMIT $numOfPrices";

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute([$product_id]);

        return $statement->fetchAll();
    }

    public function addPriceFor($product_id, $price)
    {
        $sql = "INSERT INTO ProductPrice (product_id, price) VALUES (?,?)";
        DB::getPDO()->prepare($sql)->execute([$product_id, $price]);
    }

    public function getProductNamesAndPrices($category_id, $numOfProducts, $expensive)
    {

        $last_date_sql = "SELECT date_changed FROM ProductPrice WHERE product_id = P . product_id"
            . " ORDER BY date_changed DESC LIMIT 1";

        $sql = "SELECT P . name AS name, PP . price AS price FROM Product AS P "
            . "JOIN ProductPrice AS PP ON P . product_id = PP . product_id "
            . "WHERE P . category_id = ? AND PP . date_changed = ($last_date_sql)"
            . "ORDER by price " . ($expensive ? "DESC" : "ASC")
            . " LIMIT $numOfProducts";

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute([$category_id]);

        return $statement->fetchAll();
    }

    public function getRecentContentForUser($user_id, $post_limit, $product_limit)
    {
        // get all posts from my followers or from me
        $posts = "SELECT 'post' AS type, post_id AS id, published_on AS date FROM Post "
            . "LEFT JOIN Follower ON(followee = user_id AND follower = $user_id OR user_id = $user_id) "
            . "LIMIT $post_limit";

        // get all products from my followers or from me
        $products = "SELECT 'product' AS type, product_id AS id, published_on AS date FROM Product "
            . "LEFT JOIN Follower ON(followee = user_id AND follower = $user_id OR user_id = $user_id) "
            . "LIMIT $product_limit";

        $sql = "SELECT type, id FROM($posts UNION ALL $products) T ORDER BY date DESC";

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

}