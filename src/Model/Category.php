<?php

namespace Model;


use DB\DBModel;
use Sawazon\RSSable;

class Category extends DBModel implements RSSable
{

    public function getColumnNames()
    {
        return ['category_id', 'name', 'description'];
    }

    public function getRSS()
    {
        $products = $this->getProducts();

        $rss = "<title>$this->name</title>";
        $rss .= "<description>$this->description</description>";
        $rss .= "<category>$this->name</category>";

        // TODO loop through products

        return $rss;

    }

    public function getProducts()
    {
        return (new Product())->loadAll("WHERE category_id = ?", [$this->category_id]);
    }

}