<?php

namespace View;

use Model\Category;

class CategoryGrid extends Template
{
    public function __construct()
    {
        parent::__construct('category/grid');

        $categories = (new Category())->loadAll("ORDER BY name");
        $n = count($categories);

        $rows = [];

        $r = -1;
        for ($i = 0; $i < $n; $i++) {
            if ($i % 3 == 0) {
                $r++;
                $rows[$r] = [];
            }
            $rows[$r][$i % 3] = new CategoryThumbnail($categories[$i]);
        }

        $rows = array_map(function ($r) {
            return new CategoryRow($r);
        }, $rows);

        $this->addParam('rows', $rows);
    }
}