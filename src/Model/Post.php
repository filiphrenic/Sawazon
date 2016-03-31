<?php

namespace Model;

use DB\DBModel;
use Sawazon\RSSable;

class Post extends DBModel implements RSSable
{

    public function getColumnNames()
    {
        return ['post_id', 'user_id', 'heading', 'content', 'published_on'];
    }

    public function getRSS()
    {
        /** @var User $author */
        $author = $this->user;

        $rss = "<title>$this->heading</title>";
        $rss .= "<description>$this->content</description>";
        $rss .= "<author>$author->first_name $author->last_name</author>";
        $rss .= "<pubDate>$this->published_on</pubDate>";

        return $rss;
    }
}