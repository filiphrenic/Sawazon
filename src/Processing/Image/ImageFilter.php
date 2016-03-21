<?php

namespace Processing\Image;


interface ImageFilter
{
    /**
     * Apply some actions to the given resource
     * @param resource $resource
     */
    public function apply($resource);
}