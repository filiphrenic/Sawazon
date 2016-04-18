<?php

namespace Processing\Image;

use Symfony\Component\Yaml\Yaml;

class CompositeIF implements ImageFilter
{

    private static $FILTERS = null;
    private static $FILENAME = __DIR__ . '/../../../conf/image_filters.yaml';

    public static function getFilters()
    {
        if (self::$FILTERS == null)
            self::$FILTERS = Yaml::parse(file_get_contents(self::$FILENAME));
        return self::$FILTERS;
    }

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