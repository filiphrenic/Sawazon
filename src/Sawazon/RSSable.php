<?php

namespace Sawazon;

interface RSSable
{

    /**
     * @return string rss representation of this object
     */
    public function getRSS();
}