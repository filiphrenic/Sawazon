<?php

namespace Processing\Text;

use DB\DBTaggable;

class TagsEmphasis implements TextFilter
{

    public function apply($text = "")
    {
        $pattern = DBTaggable::$TAG_PATTERN;
        $pattern = "%#$pattern%u";

        $f = function ($matches) {
            $word = $matches['tag'];
            return "<b>#$word</b>";
        };

        return preg_replace_callback($pattern, $f, $text);
    }

}