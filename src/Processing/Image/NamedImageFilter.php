<?php

namespace Processing\Image;

class NamedImageFilter implements ImageFilter
{

    /** @var  int */
    private $filterType;

    public function __construct($type = "")
    {
        $constant_name = "IMG_FILTER_" . strtoupper($type);
        if (!defined($constant_name)) throw new \Exception('Filter doesnt exist');
        $this->filterType = constant($constant_name);
    }

    public function apply($image)
    {
        imagefilter($image, $this->filterType);
    }

}