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
        $rss = "<title>$this->name</title>";
        $rss .= "<description>$this->description</description>";
        $rss .= "<category>$this->name</category>";

        $rss .= "<channel>";
        $rss .= "<title>Products in category $this->name</title>";
        /** @var Product $product */
        foreach ($this->product_all as $product) {
            $rss .= "<item>" . $product->getRSS() . "</item>";
        }
        $rss .= "</channel>";

        return $rss;
    }

    public function toOption()
    {
        $id = $this->category_id;
        $name = $this->name;
        return "<div class=\"col-sm-3 categ-option\"><input type=\"checkbox\" name=\"categories\" value=\"$id\"/> $name</div>";
    }

}