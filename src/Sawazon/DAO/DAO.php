<?php

namespace Sawazon\DAO;

interface DAO
{

    /**
     * @param int $n number of products
     * @return array
     */
    public function getMostViewedProducts($n = 5);

    /**
     * @param int $product_id
     * @param int $numOfPrices
     * @return array [ (price, date) ]
     */
    public function getPricesFor($product_id, $numOfPrices);

    public function addPriceFor($product_id, $price);

    public function getProductNamesAndPrices($category_id, $numOfProducts, $expensive);

    public function getRecentContentForUser($user_id, $post_limit, $user_limit);

    public function getTaggedWith($tag);

    public function updateTags($id, $type, $tags);

    public function checkFollows($follower, $followee);

    public function modifyFollow($follower, $followee, $action);
}