<?php

namespace Processing\Text;

interface TextFilter
{
    /**
     * @param string $text
     * @return string
     */
    public function apply($text = "");
}