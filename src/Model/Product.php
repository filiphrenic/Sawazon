<?php

namespace Model;

use DB\DBModel;
use Sawazon\RSSable;

class Product extends DBModel implements RSSable
{

    public function getColumnNames()
    {
        return ['product_id', 'user_id', 'category_id', 'name', 'description',
            'allow_review', 'published_on', 'view_count'];
    }

    public function getRSS()
    {
        /** @var User $author */
        $author = $this->user;
        /** @var Category $category */
        $category = $this->category;

        $rss = "<title>$this->name</title>";
        $rss .= "<description>$this->description</description>";
        $rss .= "<author>$author->first_name $author->last_name</author>";
        $rss .= "<category>$category->name</category>";

        $rss .= "<channel>";
        $rss .= "<title>Product reviews</title>";
        /** @var Review $review */
        foreach ($this->review_all as $review) {
            $rss .= "<item>" . $review->getRSS() . "</item>";
        }
        $rss .= "</channel>";

        return $rss;
    }


}