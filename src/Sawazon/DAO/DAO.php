<?php

namespace Sawazon\DAO;

interface DAO
{

    /**
     * @param int $n number of products
     * @return array
     */
    public function getMostViewedProducts($n = 5);
}