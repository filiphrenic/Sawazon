<?php

namespace Model;

use DB\DBModel;
use Sawazon\RSSable;

class Review extends DBModel implements RSSable
{
    public function getColumnNames()
    {
        return ['review_id', 'product_id', 'user_id', 'content', 'rating', 'date_reviewed'];
    }

    public function getRSS()
    {
        /** @var User $author */
        $author = $this->user;

        $rss = "<title>Review no.$this->review_id / rating: $this->rating</title>";
        $rss .= "<description>$this->content</description>";
        $rss .= "<author>$author->first_name $author->last_name</author>";
        $rss .= "<pubDate>$this->date_reviewed</pubDate>";

        return $rss;
    }
}