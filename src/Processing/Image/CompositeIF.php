<?php

namespace Processing\Image;

class CompositeIF implements ImageFilter
{

    /** @var array */
    private $filters;

    /**
     * CompositeIF constructor.
     * @param array $filters
     */
    public function __construct($filters = array())
    {
        $this->filters = $filters;
    }

    /**
     * @param ImageFilter $filter
     */
    public function add($filter)
    {
        $this->filters[] = $filter;
    }

    public function apply($resource)
    {
        /** @var ImageFilter $filter */
        foreach ($this->filters as $filter)
            $filter->apply($resource);
    }

}