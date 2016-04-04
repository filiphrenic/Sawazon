<?php

namespace Processing\Image;

class NamedImageFilter implements ImageFilter
{

    /** @var  int */
    private $filterType;

    public function __construct($name = "")
    {
        $this->filterType = constant("IMG_FILTER_" . $name);
    }

    public function apply($image)
    {
        imagefilter($image, $this->filterType);
    }

}